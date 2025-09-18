<?php

namespace App\Exports\Pims;

use App\Models\Vtt\PoHeader;
use App\Models\Vtt\PoDetail;

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


//class PRExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithColumnFormatting
class POExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles
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
            'B' => 100,
            'G' => 12,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A10:F11'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A2:F2')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:F4')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('A4:F4')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1:F5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('B7:F7')->applyFromArray(['alignment' => ['horizontal' => 'left']]);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A10:F11')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A10:F11')->getAlignment()->setVertical('center');
            },
        ];
    }


    public function view(): View
    {

        $PoHeader = PoHeader::with('PoDetail')->with('office')->find($this->q);

        $poDetailItems = collect(PoDetail::with('items' )
            ->where('po_header_id', $this->q)
            ->select('id', 'po_header_id', 'item_id', 'unit_cost as item_unit_cost',  'item_description as item', 'category_id', 'unit_id as item_unit', 'quantity_approved as item_total_qty',
                DB::raw('(quantity_approved * unit_cost) as item_total_cost'))
            ->get()->keyBy('id')->toArray());

        $this->rowCount = $PoHeader->PoDetail()->count() +  ($poDetailItems->count() * 2);
        $this->headerCount = $poDetailItems->count();
        // Count per category items
        $sql = collect(PoDetail::where('po_header_id', $this->q)
            ->select('id', 'po_header_id', 'item_id', 'unit_cost as item_unit_cost',  'item_description as item', 'category_id', 'unit_id as item_unit', 'quantity_approved as item_total_qty',
                DB::raw('(quantity_approved * unit_cost) as item_total_cost'))
            ->get());

        $categoryItemCount = $sql->map(function ($row) {
            return $row->count();
        });

        $this->categoryItemCount = $categoryItemCount->toArray();

        return view('exports.vtt.pr_details', [
            'poHeader' => $PoHeader,
            'poDetailItems' => $poDetailItems,
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

        $start = 12;
        $cnt = 1;
        $totalItem = 0;
        $totalRow = $start;

        ///////////////////////////////////////////////////////////
        // Begin:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////

        foreach ($this->categoryItemCount  as $key => $value) {
            $cnt += 1;
            $totalItem += $value;
            $totalRow += ($value + 2);

            // Category Style
            $sheet->getStyle('A'.($totalRow-($value+2)).':F'.($totalRow-($value+2)))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->getStyle('A'.($totalRow-($value+2)).':F'.($totalRow-($value+2)))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ccecfd'],]);

            // SubTotal Style
            $sheet->getStyle('A'.($totalRow-1).':F'.($totalRow-1))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'EAF2DE'],]);

        }

        ///////////////////////////////////////////////////////////
        // End:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////


        // Border Style
        $sheet->getStyle('A'.($start-2).':F'.($totalRow))->applyFromArray($styleArray);

        $sheet->getStyle('B'.($start+1).':B'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start+1).':F'.$totalRow)->getAlignment()->setVertical('center');
        $sheet->getStyle('E'.($start+1).':F'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start+1).':F'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H'.($start+1).':F'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Grand total
        $sheet->getStyle('A'.($totalRow).':F'.($totalRow))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'fff4cc'],]);

    }
}
