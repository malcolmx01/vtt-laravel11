<?php

namespace App\Exports\Pims;

use App\Models\Vtt\PpmpDetail;
use App\Models\Vtt\PpmpHeader;
use App\Models\Vtt\WmrHeader;
use App\Models\Vtt\WmrDetail;

use DB;
use File;
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

class WMRExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $headerCount, $DetailItems, $categoryItemCount;

    public function __construct(int $id, bool $sign)
    {
        $this->q = $id;
        $this->sign = $sign;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 10,
            'C' => 10,
            'D' => 30,
            'E' => 30,
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
                $cellRange = 'A10:G11'; // All headers
                $event->sheet->getDelegate()->getStyle('C1:G1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C2:G2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('C3:G3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('C3:G3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C4:G4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C5:G5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C1:G5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A7:G8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A7:C7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:G8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A8:G8')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:G8')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $WmrHeader = WmrHeader::with('wmrdetail', 'inspector', 'witness', 'returned', 'received', 'certified', 'disposal')->find($this->q);
        $this->rowCount = $WmrHeader->wmrdetail()->count();
//dd($WmrHeader);
        $this->DetailItems =
        WmrDetail::
            where('wmr_header_id', $this->q)
            ->select(
                'id',
                'wmr_no' ,
                'wmr_header_id' ,
                'item_id' ,
                'unit_cost' ,
                'item_description' ,
                'details' ,
                'unit_id' ,
                'unit_description',
                'quantity' ,
                'invoice_or_no' ,
                'unit_cost as item_unit_cost',
                'item_description as item',
                'unit_description as item_unit',
                'quantity as item_total_qty',

                DB::raw('(quantity * unit_cost) as item_total_cost'))

            ->get();

//        dd($this->DetailItems);

        return view('exports.vtt.wmr_excel', [
            'header' => $WmrHeader,
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


        $start = 8;
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

        $sheet->getStyle('C'.($start).':C'.$totalRow+8)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':F'.$totalRow+8)->getAlignment()->setVertical('top');

        $sheet->getStyle('E'.($start+1).':G'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start).':G'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A6:F6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('F'.($start+1).':F'.($totalRow+8))->applyFromArray($styleArray);
        $sheet->getStyle('G'.($start+1).':G'.($totalRow+8))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':C'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
//        $sheet->getStyle('F'.($start+1).':F'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('D'.($start+1).':F'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'left']]);
//        $sheet->getStyle('D'.($start+1).':D'.($totalRow+1))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow+1).':G'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('C'.($totalRow+3).':E'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Footer

        // RETURNED BY:
        $sheet->getStyle('A'.($totalRow+9).':D'.($totalRow+15))->applyFromArray($styleArray);
        // RECEIVED BY:
        $sheet->getStyle('E'.($totalRow+9).':G'.($totalRow+15))->applyFromArray($styleArray);

        // Returned By: & Received By:
        $sheet->getStyle('A'.($totalRow+12).':G'.($totalRow+12))->getFont()->setUnderline(true);

        // CERTIFIED CORRECT:
        $sheet->getStyle('A'.($totalRow+16).':D'.($totalRow+22))->applyFromArray($styleArray);
        // DISPOSAL APPROVED:
        $sheet->getStyle('E'.($totalRow+16).':G'.($totalRow+22))->applyFromArray($styleArray);
        // Certified Correct: & Disposal approved:
        $sheet->getStyle('A'.($totalRow+19).':G'.($totalRow+19))->getFont()->setUnderline(true);

        // CERTIFICATION OF INSPECTION
        $sheet->getStyle('A'.($totalRow+23).':G'.($totalRow+23))->applyFromArray($styleArray);
        $sheet->getStyle('A'.($totalRow+23).':G'.$totalRow+23)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($totalRow+23).':G'.$totalRow+23)->getAlignment()->setVertical('top');

        // I hereby certify
        $sheet->getStyle('A'.($totalRow+24).':G'.($totalRow+30))->applyFromArray($styleArray);

        // PROPERTY INSPECTOR: Name & Signature:
        $sheet->getStyle('A'.($totalRow+31).':D'.($totalRow+36))->applyFromArray($styleArray);
        // WITNESS TO DIPOSITION: Name & Signature:
        $sheet->getStyle('E'.($totalRow+31).':G'.($totalRow+36))->applyFromArray($styleArray);
        // Property Inspector: & Witness to Disposition:
        $sheet->getStyle('A'.($totalRow+34).':G'.($totalRow+34))->getFont()->setUnderline(true);

        // Note:
        $sheet->getStyle('A'.($totalRow+6).':G'.$totalRow+6)->getAlignment()->setWrapText(true);

        $sheet->getStyle('A'.($totalRow+9).':G'.($totalRow+20))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('A'.($totalRow+31).':G'.($totalRow+36))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);
    }

    public function drawings()
    {
        $drawings = [];

        if ($this->sign == true){
            $WmrHeader = WmrHeader::with('wmrdetail', 'inspector', 'witness', 'returned', 'received', 'certified', 'disposal')->find($this->q);
            $this->rowCount = $WmrHeader->wmrdetail()->count();
            $start = 8;
            $cnt = 1;
            $totalItem = 0;
//        if (!empty($this->DetailItems->count())) $totalRow = $start + ($this->DetailItems->count() ?? 0);
            if (!empty($this->rowCount )) $totalRow = $start + ($this->rowCount ?? 0);
            else                                     $totalRow = $start + 1;

            if (!empty($WmrHeader->returned->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->returned->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->returned->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('C'.($totalRow+10));
                    $drawings[] = $drawing;
                }
            }
            if (!empty($WmrHeader->received->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->received->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->received->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(185);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('E'.($totalRow+10));
                    $drawings[] = $drawing;
                }
            }

            if (!empty($WmrHeader->certified->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->certified->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->certified->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('C'.($totalRow+17));
                    $drawings[] = $drawing;
                }
            }
            if (!empty($WmrHeader->disposal->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->disposal->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->disposal->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(185);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('E'.($totalRow+17));
                    $drawings[] = $drawing;
                }
            }

            if (!empty($WmrHeader->inspector->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->inspector->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->inspector->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('C'.($totalRow+32));
                    $drawings[] = $drawing;
                }
            }
            if (!empty($WmrHeader->witness->signature)){
                if(File::exists(public_path('storage/'.$WmrHeader->witness->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$WmrHeader->witness->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(185);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('E'.($totalRow+32));
                    $drawings[] = $drawing;
                }
            }
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(110);
        $drawing->setWidth(110);
        $drawing->setCoordinates('A2');
        $drawings[] = $drawing;

        return $drawings;

    }
}
