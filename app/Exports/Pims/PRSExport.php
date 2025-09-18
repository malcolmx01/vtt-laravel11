<?php

namespace App\Exports\Pims;

use App\Models\Vtt\PrsHeader;
use App\Models\Vtt\PrsDetail;

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

class PRSExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
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
            'A' => 6,
            'B' => 8,
            'C' => 42,
            'D' => 10,
            'E' => 10,
            'F' => 12,
            'G' => 20,
            'H' => 15,
            'I' => 15,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:G8'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A2:I2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A3:I3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('A3:I3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:I4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A5:I5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A7:I7')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A1:I7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A7:I7')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(25);
                $event->sheet->getDelegate()->getStyle('A8:I8')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:I7')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:I7')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A7:I7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:I9')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A9:I9')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A9:I9')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $PrsHeader = PrsHeader::with('prsdetail','office','officereturn','officereceived', 'approved', 'received', 'returned')->find($this->q);
        $this->rowCount = $PrsHeader->prsdetail()->count();

        $this->DetailItems =
        PrsDetail::
            where('prs_header_id', $this->q)
            ->with('officeuser')
            ->select(
                'id',
                'prs_no' ,
                'prs_header_id' ,
                'office_id' ,
                'item_id' ,
                'item_description' ,
                'details' ,
                'quantity' ,
                'unit_cost' ,
                'unit_id' ,
                'unit_description',
                'total_value' ,
                'packaging_id',
                'packaging_short_description',
                'trans_year' ,
                'property_no' ,
                'acct_code' ,
                'acquired' ,
                'end_user_name' ,
                'office_of_origin' ,

                'unit_cost as item_unit_cost',
                'item_description as item',
                'unit_description as item_unit',
                'quantity as item_total_qty',

                DB::raw('(quantity * unit_cost) as item_total_cost'))

            ->get();

//        dd($this->DetailItems);

        return view('exports.vtt.prs_excel', [
            'header' => $PrsHeader,
            'details' => $this->DetailItems ,
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


        $start = 9;
        $cnt = 1;
        $totalItem = 0;
        if (!empty($this->DetailItems->count())) $totalRow = $start + ($this->DetailItems->count() ?? 0);
        else                                     $totalRow = $start + 1;



        ///////////////////////////////////////////////////////////
        // Begin::  Border Style
        ///////////////////////////////////////////////////////////

        //Main border
        $sheet->getStyle('A'.($start-2).':I'.($totalRow+2))->applyFromArray($styleArray);

        //Header title
        $sheet->getStyle('A'.($start).':I'.($start))->applyFromArray($styleAllborders);
        $sheet->getStyle('A'.($start-1).':I'.($start-1))->applyFromArray($styleAllborders);

        $sheet->getStyle('A'.($start).':I'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':I'.$totalRow)->getAlignment()->setVertical('top');

        $sheet->getStyle('F'.($start+1).':I'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('F'.($start).':I'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('F'.($start+1).':F'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('G'.($start+1).':G'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('H'.($start+1).':H'.($totalRow+2))->applyFromArray($styleArray);
        $sheet->getStyle('I'.($start+1).':I'.($totalRow+2))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':B'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('D'.($start+1).':G'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow+1).':I'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

//        $sheet->getStyle('C'.($totalRow+3).':C'.($totalRow+8))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Footer
        $sheet->getStyle('A'.($totalRow+3).':D'.($totalRow+11))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($totalRow+3).':I'.($totalRow+11))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($totalRow+3).':D'.($totalRow+11))->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($totalRow+3).':D'.($totalRow+11))->getAlignment()->setVertical('top');

        $sheet->getStyle('E'.($totalRow+3).':I'.($totalRow+11))->getAlignment()->setWrapText(true);
        $sheet->getStyle('E'.($totalRow+3).':I'.($totalRow+11))->getAlignment()->setVertical('top');

        $sheet->getStyle('A'.($totalRow+9).':I'.($totalRow+9))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+9).':I'.($totalRow+9))->getFont()->setBold(true);
        $sheet->getStyle('A'.($totalRow+16).':I'.($totalRow+16))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+16).':I'.($totalRow+16))->getFont()->setBold(true);

        $sheet->getStyle('A'.($totalRow+3).':I'.($totalRow+18))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

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
