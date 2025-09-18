<?php

namespace App\Exports\Pims;

use App\Models\Vtt\AreHeader;
use App\Models\Vtt\AreDetail;

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

class AREExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $headerCount, $DetailItems, $categoryItemCount;

    public function __construct(int $id)
    {
        $this->q = $id;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 6,
            'C' => 65,
            'D' => 10,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 16,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A10:H11'; // All headers
                $event->sheet->getDelegate()->getStyle('C1:H1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C2:H2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('C3:H3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('C3:H3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C4:H4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C5:H5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C1:H5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A7:H8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A7:C7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:H8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A8:H8')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:H8')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $AreHeader = AreHeader::with('aredetail','officeFrom', 'officeBy', 'receivedby', 'receivedfrom')->find($this->q);
        $this->rowCount = $AreHeader->aredetail()->count();

        $this->DetailItems =
        AreDetail::
            where('are_header_id', $this->q)
            ->select(
                'id',
                'are_no' ,
                'are_header_id' ,
                'item_id' ,
                'unit_cost' ,
                'item_description' ,
                'details' ,
                'unit_id' ,
                'unit_description',
                'quantity' ,
                'trans_date' ,
                'remarks' ,
                'estimated_useful_life' ,
                'status' ,

                'property_no' ,
                'serial_no' ,
                'brand',
                'model',
                'year',
                'part_no',
                'cr_no',
                'chassis_no',
                'engine_no',

                'unit_cost as item_unit_cost',
                'item_description as item',
                'unit_description as item_unit',
                'quantity as item_total_qty',
                DB::raw('IF(property_no IS NULL, 0, 1) AS property_line'),
                DB::raw('IF(serial_no IS NULL, 0, 1) AS serial_line'),
                DB::raw('IF(brand IS NULL, 0, 1) AS brand_line'),
                DB::raw('IF(model IS NULL, 0, 1) AS model_line'),
                DB::raw('IF(year IS NULL, 0, 1) AS year_line'),
                DB::raw('IF(part_no IS NULL, 0, 1) AS part_line'),
                DB::raw('IF(cr_no IS NULL, 0, 1) AS cr_line'),
                DB::raw('IF(chassis_no IS NULL, 0, 1) AS chassis_line'),
                DB::raw('IF(engine_no IS NULL, 0, 1) AS engine_line'),
                DB::raw('(quantity * unit_cost) as item_total_cost'),
                DB::raw('((LENGTH(item_description) div 50) + IF((LENGTH(item_description) mod 50) > 0, 1, 0 ) ) as itemLength'),
                DB::raw('((LENGTH(details) div 50) + IF((LENGTH(details) mod 50) > 0, 1, 0 ) ) as itemLengthDetails'))

            ->get();

//        dd($this->DetailItems);

        return view('exports.vtt.are_excel', [
            'header' => $AreHeader,
            'details' => $this->DetailItems ,
        ]);

    }

//    /** *  The style is set  * @param Worksheet $sheet * @throws \PhpOffice\PhpSpreadsheet\Exception */
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


        $start = 8;
        $cnt = 1;
        $totalItem = 0;
        if (!empty($this->DetailItems->count())) $totalRow = $start + ($this->DetailItems->count() ?? 0);
        else                                     $totalRow = $start + 1;



        ///////////////////////////////////////////////////////////
        // Begin::  Border Style
        ///////////////////////////////////////////////////////////

        //Main border
        $sheet->getStyle('A'.($start-1).':H'.($totalRow+8))->applyFromArray($styleArray);

        //Header title
        $sheet->getStyle('A'.($start).':H'.($start))->applyFromArray($styleAllborders);

        $sheet->getStyle('C'.($start).':C'.$totalRow+8)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':H'.$totalRow+8)->getAlignment()->setVertical('top');

        $sheet->getStyle('E'.($start+1).':H'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start).':H'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A6:F6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('F'.($start+1).':F'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('G'.($start+1).':G'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('H'.($start+1).':H'.($totalRow+8))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':B'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('D'.($start+1).':E'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow+1).':H'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('C'.($totalRow+3).':C'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Footer
        $sheet->getStyle('A'.($totalRow+9).':C'.($totalRow+14))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($totalRow+9).':H'.($totalRow+14))->applyFromArray($styleArray);
        $sheet->getStyle('A'.($totalRow+12).':H'.($totalRow+12))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+9).':H'.($totalRow+14))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        $sheet->getStyle('A'.($totalRow+15).':C'.($totalRow+20))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($totalRow+15).':H'.($totalRow+20))->applyFromArray($styleArray);
        $sheet->getStyle('A'.($totalRow+18).':H'.($totalRow+18))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+15).':H'.($totalRow+20))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

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
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}
