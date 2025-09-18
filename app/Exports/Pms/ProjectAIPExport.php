<?php

namespace App\Exports\Pms;

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

class ProjectAIPExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $Projects, $servicesItemCount;

    public function __construct()
    {
        //
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 50,
            'C' => 30,
            'D' => 14,
            'E' => 16,
            'F' => 16,
            'G' => 22,
            'H' => 30,
            'I' => 30,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
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

        $projectlist = Project::with('service')
        ->select(
            'id', 'series', 'code', 'transaction_year', 'project', 'description', 'objectives', 'project_owner', 'point_person', 'point_person_id',
            'designation', 'contact_nos', 'email_address',  'beneficiaries', 'district',  'districts', 'multiple_locations',  'locations', 'REGION_C', 'PROVINCE_C',
            'CITYMUN_ID', 'BARANGAY_ID', 'BARANGAY', 'CITYMUN', 'scope_details', 'longitude', 'latitude', 'contractor_id', 'contractor', 'project_cost',
            'implementing_agency', 'fund_id', 'fund_source', 'services_id', 'implementation_mode_id', 'sector', 'sector_id', 'subsector', 'subsectors', 'subsector_id',
            'category', 'category_id', 'subcategories', 'subcategory_id', 'activities', 'donor', 'target_start_date', 'target_end_date', 'actual_start_date', 'actual_end_date',
            'duration', 'fmis_control_no', 'bid_no', 'aip_ref_no', 'status', 'user_id', 'deleted_at', 'created_at', 'updated_at', 'project_image',
            'contact_person_id', 'expected_output', 'ps', 'mooe', 'capital_outlay', 'cc_adaptation', 'cc_mitigation', 'cc_typology_code',
            DB::raw('(ps + mooe + capital_outlay) as amount_total')
        )
        ->get()
        ->keyBy('id');

        $Projects = collect($projectlist->toArray())->groupBy('service.services');

        $this->rowCount = (($Projects->count() * 2) + $projectlist->count());

        $servicesItemCount = $projectlist->groupBy('service.services')->map(function ($row) {
            return $row->count();
        });

        $this->servicesItemCount = $servicesItemCount->toArray();

        return view('exports.pms.project_aip_printable', ['Projects' => $Projects ]);
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
