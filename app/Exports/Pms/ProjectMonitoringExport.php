<?php

namespace App\Exports\Pms;

use App\Models\Pms\Monitoring;

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

class ProjectMonitoringExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $ProjMonitoringItems;

    public function __construct()
    {
        //
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 50,
            'C' => 30,
            'D' => 14,
            'E' => 16,
            'F' => 16,
            'G' => 22,
            'H' => 30,
            'I' => 30,
            'J' => 20,
            'K' => 10,
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

                $event->sheet->getDelegate()->getStyle('A1:K9')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A1:K9')->getAlignment()->setVertical('center');

                $event->sheet->getDelegate()->getStyle('A2:K2')->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle('A2:K2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A3:K3')->getFont()->setSize(17);

                $event->sheet->getDelegate()->getStyle('A7:C7')->getFont()->setSize(21);

                $event->sheet->getDelegate()->getRowDimension('10')->setRowHeight(40);
                $event->sheet->getDelegate()->getStyle('A10:K10')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A10:K10')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A10:K10')->getFont()->setBold(true);
            },
        ];
    }


    public function view(): View
    {

        $ProjMonitoring = Monitoring::with('proj_status')->get();
        $this->rowCount = $ProjMonitoring->count();
        return view('exports.pms.proj_monitoring_printable', ['ProjMonitoring' => $ProjMonitoring ]);
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
        $totalRow = $start +  $this->rowCount;

        ///////////////////////////////////////////////////////////
        // Begin::  Border Style
        ///////////////////////////////////////////////////////////

        //Main border
        $sheet->getStyle('A'.($start-1).':K'.($totalRow))->applyFromArray($styleAllborders);

        $sheet->getStyle('A'.($start-1).':K'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('F'.($start-1).':F'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.$totalRow.':E'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.($start-1).':K'.$totalRow)->getAlignment()->setVertical('top');

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
