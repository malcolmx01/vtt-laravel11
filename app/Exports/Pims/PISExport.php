<?php

namespace App\Exports\Pims;

use App\Models\Vtt\PisHeader;
use App\Models\Vtt\PisDetail;

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

class PISExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
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
            'B' => 42,
            'C' => 12,
            'D' => 12,
            'E' => 13,
            'F' => 15,
            'G' => 15,
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
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A2:G2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A3:G3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('A3:G3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:G4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A5:G5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A6:G6')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A1:G7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:G8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getRowDimension('8')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A8:G8')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A8:G8')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A8:G8')->applyFromArray(['alignment' => ['horizontal' => 'center']]);

                $event->sheet->getDelegate()->getStyle('A9:G9')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A9:G9')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A9:G9')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $PisHeader = PisHeader::with('pisdetail','office', 'transferor', 'transferee')->find($this->q);

        $this->rowCount = $PisHeader->pisdetail()->count();

        $this->DetailItems =
        PisDetail::
            where('pis_header_id', $this->q)
            ->select(
                'id',
                'pis_no' ,
                'pis_header_id' ,
                'item_id' ,
                'item_description' ,
                'details' ,
                'quantity' ,
                'unit_cost' ,
                'unit_id' ,
                'unit_description' ,
                'total_value' ,
                'trans_date' ,
                'property_no' ,
                'classification_no' ,
                'supplier' ,
                'po_no' ,
                'po_date' ,
                'invoice_date' ,
                'invoice_no' ,
                'serial_no' ,
                'estimated_useful_life' ,
                'status' ,
                'remarks' ,
                'charges' ,

                'unit_cost as item_unit_cost',
                'item_description as item',
                'unit_description as item_unit',
                'quantity as item_total_qty',

                DB::raw('(quantity * unit_cost) as item_total_cost'))

            ->get();

//        dd($this->DetailItems);

        return view('exports.vtt.pis_excel', [
            'header' => $PisHeader,
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
        $sheet->getStyle('A'.($start-1).':G'.($totalRow+8))->applyFromArray($styleArray);

        //Header title
        $sheet->getStyle('A'.($start).':G'.($start))->applyFromArray($styleAllborders);

        $sheet->getStyle('A'.($start).':G'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':G'.$totalRow)->getAlignment()->setVertical('top');

        $sheet->getStyle('F'.($start+1).':G'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('F'.($start).':G'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('F'.($start+1).':F'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('G'.($start+1).':G'.($totalRow+8))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':A'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('C'.($start+1).':E'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow+1).':G'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('C'.($totalRow+3).':C'.($totalRow+8))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Footer
        $sheet->getStyle('A'.($totalRow+9).':C'.($totalRow+18))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($totalRow+9).':G'.($totalRow+18))->applyFromArray($styleArray);
        $sheet->getStyle('A'.($totalRow+14).':G'.($totalRow+14))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+14).':G'.($totalRow+14))->getFont()->setBold(true);
        $sheet->getStyle('A'.($totalRow+16).':G'.($totalRow+16))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+16).':G'.($totalRow+16))->getFont()->setBold(true);

        $sheet->getStyle('A'.($totalRow+9).':G'.($totalRow+18))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

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
