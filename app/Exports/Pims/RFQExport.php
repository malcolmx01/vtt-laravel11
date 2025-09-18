<?php

namespace App\Exports\Pims;

use App\Models\Vtt\RfqHeader;
use App\Models\Vtt\RfqDetail;

use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

//use PhpOffice\PhpSpreadsheet\Style\
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class RFQExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $headerCount, $categoryItemCount;

    public function __construct(int $id)
    {
        $this->q = $id;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 75,
            'B' => 10,
            'C' => 10,
            'D' => 20,
            'E' => 20,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A7:E11'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:E1')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A2:E2')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1:E1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:E4')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('A4:E4')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A9')->getAlignment()->setIndent(5);
                $event->sheet->getDelegate()->getRowDimension('15')->setRowHeight(30);
                $event->sheet->getDelegate()->getStyle('A15:E15')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A15:E15')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A15:E15')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A1:E5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },
        ];
    }


    public function view(): View
    {
        $RfqHeader = RfqHeader::with('prdetail', 'prepared', 'approved')->find($this->q);

        $RfqDetailItems = collect(RfqDetail::
            with('items' )
            ->where('rfq_header_id', $this->q)
            ->select(
                'id', 'rfq_no', 'pr_no', 'item_id', 'unit_cost', 'item_description as item', 'quotation_description',  'unit_id as item_unit','quantity_approved as item_total_qty',
                DB::raw('(quantity_requested * unit_cost) as item_total_cost'))
            ->get()->keyBy('id')->toArray())->groupBy('items.item');

        $this->rowCount = $RfqHeader->rfqdetail()->count() +  ($RfqDetailItems->count());
        $this->headerCount = $RfqDetailItems->count();
        // Count per category items
        $sql = collect(RfqDetail::with('items' )
            ->where('rfq_header_id', $this->q)
            ->select('id', 'rfq_header_id', 'rfq_no', 'pr_no', 'item_id', 'unit_cost as item_unit_cost', 'quotation_description',  'item_description as item', 'unit_id as item_unit', 'quantity_approved as item_total_qty')
            ->get());

        $categoryItemCount = $sql->groupBy('item_id')->map(function ($row) {
            return $row->count();
        });

        $this->categoryItemCount = $categoryItemCount->toArray();

        return view('exports.vtt.rfq_details', [
            'RfqHeader' => $RfqHeader,
            'RfqDetailItems' => $RfqDetailItems,
        ]);

    }

    /** *  The style is set  * @param Worksheet $sheet * @throws \PhpOffice\PhpSpreadsheet\Exception */
    public function styles(Worksheet $sheet)
    {

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $start = 15;
        $cnt = 1;
        $totalItem = 0;
        $totalRow = $start;

        ///////////////////////////////////////////////////////////
        // Begin:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////

        foreach ($this->categoryItemCount  as $key => $value) {
            $cnt += 1;
            $totalItem += $value;
            $totalRow += ($value);

            // Category Style
            //$sheet->getStyle('A'.($totalRow-($value)).':E'.($totalRow-($value)))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        }

        ///////////////////////////////////////////////////////////
        // End:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////


        // Border Style
        $sheet->getStyle('A'.($start).':E'.($totalRow))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':A'.$totalRow)->getAlignment()->setWrapText(true);


        $sheet->getStyle('A'.($start+2).':E'.$totalRow)->getAlignment()->setVertical('center');

        $sheet->getStyle('B'.($start+1).':C'.$totalRow)->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        $sheet->getStyle('D'.($start+1).':E'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.($totalRow+1).':D'.$totalRow+1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);

    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(110);
        $drawing->setWidth(110);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
