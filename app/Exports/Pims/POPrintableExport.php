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
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class POPrintableExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
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
            'A' => 12,
            'B' => 6,
            'C' => 40,
            'D' => 12,
            'E' => 14,
            'F' => 18,
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
                $event->sheet->getDelegate()->getStyle('C1:F1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C2:F2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('C3:F3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('C3:F3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C4:F4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C5:F5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C1:F5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A7:F8')->getAlignment()->setVertical('center');
//                $event->sheet->getColumnDimension('A')->setRowHeight(10);
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A11:F11')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A11:F11')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A11:F11')->getFont()->setBold(true);
//                $event->sheet->getDelegate()->getStyle('B7:H7')->applyFromArray(['alignment' => ['horizontal' => 'left']]);
//                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
//                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
//                $event->sheet->getDelegate()->getStyle('A10:H11')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
//                $event->sheet->getDelegate()->getStyle('A10:H11')->getAlignment()->setVertical('center');
            },
        ];
    }


    public function view(): View
    {

        $PoHeader = PoHeader::with('PoDetail', 'prepared', 'approved')->with('office')->find($this->q);

        $poDetailItems = collect(PoDetail::with('items' )
            ->where('po_header_id', $this->q)
            ->select('id', 'po_header_id', 'item_id', 'unit_cost as item_unit_cost',  'item_description as item',  'unit_id as item_unit', 'quantity_approved as item_total_qty',
                DB::raw('(quantity_approved * unit_cost) as item_total_cost'))
            ->get()->keyBy('id')->toArray())->groupBy('po_header_id');

        $this->rowCount = $PoHeader->PoDetail()->count() +  ($poDetailItems->count() * 2);
        $this->headerCount = $poDetailItems->count();
        // Count per category items
        $sql = collect(PoDetail::where('po_header_id', $this->q)
            ->select('id', 'po_header_id','item_id', 'unit_cost as item_unit_cost',  'item_description as item',  'unit_id as item_unit', 'quantity_approved as item_total_qty',
                DB::raw('(quantity_approved * unit_cost) as item_total_cost'))
            ->get());

        $categoryItemCount = $sql->groupBy('po_header_id')->map(function ($row) {
            return $row->count();
        });

        $this->categoryItemCount = $categoryItemCount->toArray();

        return view('exports.vtt.po_printable', [
            'poHeader' => $PoHeader,
            'poDetailItems' => $poDetailItems,
        ]);

    }

    /** *  The style is set  * @param Worksheet $sheet * @throws \PhpOffice\PhpSpreadsheet\Exception */
    public function styles(Worksheet $sheet)
    {

        $styleAllborders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];


        $start = 11;
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
            $sheet->getStyle('A'.($totalRow-($value+1)).':F'.($totalRow-($value+1)))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
//            $sheet->getStyle('A'.($totalRow-($value+1)).':F'.($totalRow-($value+1)))->applyFromArray($styleArray);
//            $sheet->getStyle('A'.($totalRow-($value+2)).':H'.($totalRow-($value+2)))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ccecfd'],]);

            // SubTotal Style
//            $sheet->getStyle('A'.($totalRow-1).':H'.($totalRow-1))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'EAF2DE'],]);
//            $sheet->getStyle('A'.($totalRow).':F'.($totalRow))->applyFromArray($styleArray);
            $sheet->getStyle('A'.($totalRow).':F'.($totalRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        }

        ///////////////////////////////////////////////////////////
        // End:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////
        // Begin::  Border Style
        ///////////////////////////////////////////////////////////

        //Main border
        $sheet->getStyle('A'.($start-4).':F'.($totalRow+9))->applyFromArray($styleArray);

        //Purchase request
        $sheet->getStyle('A'.($start-4).':C'.($start-4))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start-4).':F'.($start-4))->applyFromArray($styleArray);

        //Requisitioning office / P.R No. and Date
        $sheet->getStyle('A'.($start-3).':C'.($start-1))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start-3).':F'.($start-1))->applyFromArray($styleAllborders);
//        $sheet->getStyle('C'.($start-3).':F'.($start-3))->getFont()->setUnderline(true);

        //Header title
        $sheet->getStyle('A'.($start).':F'.($start))->applyFromArray($styleAllborders);

        $sheet->getStyle('C'.($start).':C'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':F'.$totalRow)->getAlignment()->setVertical('top');

        $sheet->getStyle('E'.($start+1).':F'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start).':F'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+9))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+9))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+9))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+9))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+9))->applyFromArray($styleArray);
        $sheet->getStyle('F'.($start+1).':F'.($totalRow+9))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':B'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow+1).':F'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Certification
        $sheet->getStyle('C'.($totalRow+8).':C'.($totalRow+9))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('C'.($totalRow+8).':C'.($totalRow+8))->getFont()->setUnderline(true);

        // Purpose
        $sheet->getStyle('A'.($totalRow+10).':F'.($totalRow+11))->applyFromArray($styleArray);
//        $sheet->getStyle('F'.($totalRow+10).':F'.($totalRow+11))->applyFromArray($styleArray);

        // Recommendation and approval
        $sheet->getStyle('C'.($totalRow+12).':C'.($totalRow+12))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($totalRow+12).':F'.($totalRow+12))->applyFromArray($styleArray);
        $sheet->getStyle('A'.($totalRow+12).':B'.($totalRow+16))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($totalRow+12).':C'.($totalRow+16))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($totalRow+12).':F'.($totalRow+16))->applyFromArray($styleArray);

        $sheet->getStyle('C'.($totalRow+15).':F'.($totalRow+16))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('C'.($totalRow+15).':F'.($totalRow+15))->getFont()->setUnderline(true);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
//        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(110);
        $drawing->setWidth(110);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}
