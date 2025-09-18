<?php

namespace App\Exports\Reports;

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
use App\Models\Pms\Project;

class POExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $ItemCount;

    public function __construct()
    {
        //
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 50,
            'C' => 30,
            'D' => 14,
            'E' => 16,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /*$cellRange = 'A9:K11'; // All headers*/

                $event->sheet->getDelegate()->getStyle('A1:N6')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A1:N6')->getAlignment()->setVertical('center');



                $event->sheet->getDelegate()->getStyle('A2:N2')->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('A2:N2')->getFont()->setBold(true);

                $event->sheet->getDelegate()->getStyle('A5:N5')->getFont()->setSize(21);

                $event->sheet->getDelegate()->getRowDimension('9')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A9:N10')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A9:N10')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A9:N10')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {
        return view('exports.reports.op');
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


//        $start = 10;
//        $totalRow = $start +  $this->rowCount;

        $start = 11;
        $cnt = 1;
        $totalItem = 0;
        $totalRow = $start;

        ///////////////////////////////////////////////////////////
        // Begin:: Services and Subtotal Style
        ///////////////////////////////////////////////////////////

        foreach ($this->servicesItemCount  as $key => $value) {
            $cnt += 1;
            $totalItem += $value;
            $totalRow += ($value + 2);

            // Services Style
            $sheet->getStyle('A'.($totalRow-($value+2)).':N'.($totalRow-($value+2)))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->getStyle('A'.($totalRow-($value+2)).':N'.($totalRow-($value+2)))->getAlignment()->setVertical('center');
            $sheet->getRowDimension(($totalRow-($value+2)))->setRowHeight(30);

            $sheet->getStyle('A'.($totalRow-($value+2)).':N'.($totalRow-($value+2)))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ccecfd'],]);

            // SubTotal Style
            $sheet->getStyle('A'.($totalRow-1).':N'.($totalRow-1))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'EAF2DE'],]);

        }


        ///////////////////////////////////////////////////////////
        // Begin::  Border Style
        ///////////////////////////////////////////////////////////

        //Main border
        $sheet->getStyle('A'.($start-2).':N'.($totalRow))->applyFromArray($styleAllborders);

        $sheet->getStyle('A'.($start-1).':N'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('H'.($start-1).':K'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B'.($totalRow).':N'.($totalRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.($start-1).':N'.$totalRow)->getAlignment()->setVertical('center');

        $sheet->getStyle('D'.($start-1).':E'.$totalRow)->applyFromArray(['alignment' => ['horizontal' => 'center']]);

        // Grand total
        $sheet->getStyle('A'.($totalRow).':N'.($totalRow))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'fff4cc'],]);
        $sheet->getRowDimension($totalRow)->setRowHeight(30);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(110);
        $drawing->setWidth(110);
        $drawing->setCoordinates('D2');

        return $drawing;
    }

}
