<?php

namespace App\Exports\Pims;

use App\Models\Vtt\SaiHeader;
use App\Models\Vtt\SaiDetail;

use App\Models\Vtt\WmrHeader;
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

class SAIExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
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
            'B' => 40,
            'C' => 10,
            'D' => 14,
            'E' => 26,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A10:E11'; // All headers
                $event->sheet->getDelegate()->getStyle('C1:E1')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C2:E2')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('C3:E3')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('C3:E3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('C4:E4')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('C5:E5')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A1:E5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:E8')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A7:E7')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A7:E7')->getFont()->setSize(21);
                $event->sheet->getDelegate()->getStyle('A7:E7')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A7:E9')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A9:E9')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A8:E9')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $SaiHeader = SaiHeader::with('saidetail','office', 'prepared', 'inquired')->find($this->q);
        $this->rowCount = $SaiHeader->saidetail()->count();

        $this->DetailItems =
        SaiDetail::
            where('sai_header_id', $this->q)
            ->select(
                'id',
                'sai_no' ,
                'sai_header_id' ,
                'item_id' ,
                'unit_cost' ,
                'item_description' ,
                'details' ,
                'unit_id' ,
                'unit_description',
                'quantity' ,
                'status_of_stock' ,

                'unit_cost as item_unit_cost',
                'item_description as item',
                'unit_description as item_unit',
                'quantity as item_total_qty',

                DB::raw('(quantity * unit_cost) as item_total_cost'))

            ->get();

//        dd($this->DetailItems);

        return view('exports.vtt.sai_excel', [
            'header' => $SaiHeader,
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
        $sheet->getStyle('A'.($start-2).':E'.($totalRow+11))->applyFromArray($styleArray);

        //Header title
        $sheet->getStyle('A'.($start-1).':E'.($start))->applyFromArray($styleAllborders);

        $sheet->getStyle('B'.($start).':B'.$totalRow+7)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start).':E'.$totalRow+7)->getAlignment()->setVertical('top');

        $sheet->getStyle('E'.($start+1).':E'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start).':E'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A6:F6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Item
        $sheet->getStyle('A'.($start+1).':A'.($totalRow+3))->applyFromArray($styleArray);
        $sheet->getStyle('B'.($start+1).':B'.($totalRow+3))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+3))->applyFromArray($styleArray);
        $sheet->getStyle('D'.($start+1).':D'.($totalRow+3))->applyFromArray($styleArray);
        $sheet->getStyle('E'.($start+1).':E'.($totalRow+3))->applyFromArray($styleArray);
//        $sheet->getStyle('F'.($start+1).':F'.($totalRow+8))->applyFromArray($styleArray);

        $sheet->getStyle('A'.($start+1).':A'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('C'.($start+1).':C'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
//        $sheet->getStyle('D'.($start+1).':D'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        $sheet->getRowDimension($totalRow+4)->setRowHeight(40);
        $sheet->getRowDimension($start)->setRowHeight(40);

        // Grand total
//        $sheet->getStyle('A'.($totalRow+1).':E'.($totalRow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
//        $sheet->getStyle('C'.($totalRow+3).':C'.($totalRow+3))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Footer
        $sheet->getStyle('A'.($totalRow+5).':B'.($totalRow+11))->applyFromArray($styleArray);
        $sheet->getStyle('C'.($totalRow+5).':E'.($totalRow+11))->applyFromArray($styleArray);
//        $sheet->getStyle('A'.($totalRow+4).':B'.($totalRow+4))->applyFromArray($styleArray);
//        $sheet->getStyle('C'.($totalRow+4).':E'.($totalRow+4))->applyFromArray($styleArray);
//        $sheet->getStyle('A'.($totalRow+12).':E'.($totalRow+12))->getFont()->setUnderline(true);
        $sheet->getStyle('A'.($totalRow+5).':E'.($totalRow+11))->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);
    }

    public function drawings()
    {
        $drawings = [];

        if ($this->sign == true){

            $SaiHeader = SaiHeader::with('saidetail','office', 'prepared', 'inquired')->find($this->q);
            $this->rowCount = $SaiHeader->saidetail()->count();

//            $WmrHeader = WmrHeader::with('wmrdetail', 'inspector', 'witness', 'returned', 'received', 'certified', 'disposal')->find($this->q);
//            $this->rowCount = $WmrHeader->wmrdetail()->count();

            $start = 8;
            $cnt = 1;
            $totalItem = 0;
//        if (!empty($this->DetailItems->count())) $totalRow = $start + ($this->DetailItems->count() ?? 0);
            if (!empty($this->rowCount )) $totalRow = $start + ($this->rowCount ?? 0);
            else                                     $totalRow = $start + 1;

            if (!empty($SaiHeader->prepared->signature)){
                if(File::exists(public_path('storage/'.$SaiHeader->prepared->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$SaiHeader->prepared->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(40);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('B'.($totalRow+6));
                    $drawings[] = $drawing;
                }
            }
            if (!empty($SaiHeader->inquired->signature)){
                if(File::exists(public_path('storage/'.$SaiHeader->inquired->signature))){
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/'.$SaiHeader->inquired->signature));
                    $drawing->setHeight(80);
                    $drawing->setOffsetX(65);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('D'.($totalRow+6));
                    $drawings[] = $drawing;
                }
            }
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(110);
        $drawing->setWidth(110);
        $drawing->setCoordinates('A1');
        $drawings[] = $drawing;

        return $drawings;
    }
}
