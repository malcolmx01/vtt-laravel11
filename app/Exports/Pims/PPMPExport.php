<?php

namespace App\Exports\Pims;

use App\Models\Vtt\PpmpHeader;
use App\Models\Vtt\PpmpDetail;

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

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


//class PPMPExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithColumnFormatting
class PPMPExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles, WithDrawings
{
    use Exportable;
    public $rowCount, $headerCount, $classificationItemCount, $ppmpHeader, $rowStart;

    public function __construct(int $id)
    {
        $this->q = $id;
        $this->rowStart = 14;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 50,
            'G' => 20,
            'H' => 7,
            'I' => 15,
            'J' => 7,
            'K' => 15,
            'L' => 7,
            'M' => 15,
            'N' => 7,
            'O' => 15,
            'P' => 7,
            'Q' => 15,
            'R' => 7,
            'S' => 15,
            'T' => 7,
            'U' => 15,
            'V' => 7,
            'W' => 15,
            'X' => 7,
            'Y' => 15,
            'Z' => 7,
            'AA' => 15,
            'AB' => 7,
            'AC' => 15,
            'AD' => 7,
            'AE' => 15,
            'AF' => 7,
            'AG' => 15,
            'AH' => 7,
            'AI' => 15,
            'AJ' => 7,
            'AK' => 15,
            'AL' => 7,
            'AM' => 15,
            'AN' => 7,
            'AO' => 15,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A10:AO13'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:AO1')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A2:AO2')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1:AO1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:AO4')->getFont()->setSize(17);
                $event->sheet->getDelegate()->getStyle('A4:AO4')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1:AO5')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('B7:AO7')->applyFromArray(['alignment' => ['horizontal' => 'left']]);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A10:AO13')->applyFromArray(['alignment' => ['horizontal' => 'center']]);
                $event->sheet->getDelegate()->getStyle('A10:AO13')->getAlignment()->setVertical('center');
            },
        ];
    }


    public function view(): View
    {
        $this->ppmpHeader = PpmpHeader::with('ppmpdetail', 'prepared', 'approved')->with('office')->find($this->q);

        $ppmpDetailItems = collect(PpmpDetail::with('category')
            ->with('classification' )
            ->with('items' )
            ->where('ppmp_header_id', $this->q)
            ->select('id', 'ppmp_header_id', 'plan_control_no', 'item_id', 'unit_cost as item_unit_cost', 'procurement_mode_code', 'item_description as item', 'category_id', 'classification_id','unit_id as item_unit',

                'jan_proposed_amt as item_jan_amt', 'feb_proposed_amt as item_feb_amt', 'mar_proposed_amt as item_mar_amt', 'apr_proposed_amt as item_apr_amt',
                'may_proposed_amt as item_may_amt', 'jun_proposed_amt as item_jun_amt', 'jul_proposed_amt as item_jul_amt', 'aug_proposed_amt as item_aug_amt',
                'sep_proposed_amt as item_sep_amt', 'oct_proposed_amt as item_oct_amt', 'nov_proposed_amt as item_nov_amt', 'dec_proposed_amt as item_dec_amt',

                'jan_proposed_qty as item_jan_qty', 'feb_proposed_qty as item_feb_qty', 'mar_proposed_qty as item_mar_qty', 'apr_proposed_qty as item_apr_qty',
                'may_proposed_qty as item_may_qty', 'jun_proposed_qty as item_jun_qty', 'jul_proposed_qty as item_jul_qty', 'aug_proposed_qty as item_aug_qty',
                'sep_proposed_qty as item_sep_qty', 'oct_proposed_qty as item_oct_qty', 'nov_proposed_qty as item_nov_qty', 'dec_proposed_qty as item_dec_qty',

                DB::raw('(jan_proposed_qty + feb_proposed_qty + mar_proposed_qty ) as item_ttl_qty_1st'),
                DB::raw('(apr_proposed_qty + may_proposed_qty + jun_proposed_qty) as item_ttl_qty_2nd'),
                DB::raw('(jul_proposed_qty + aug_proposed_qty + sep_proposed_qty) as item_ttl_qty_3rd'),
                DB::raw('(oct_proposed_qty + nov_proposed_qty + dec_proposed_qty) as item_ttl_qty_4th'),

                DB::raw('(jan_proposed_amt + feb_proposed_amt + mar_proposed_amt) as item_ttl_amt_1st'),
                DB::raw('(apr_proposed_amt + may_proposed_amt + jun_proposed_amt) as item_ttl_amt_2nd'),
                DB::raw('(jul_proposed_amt + aug_proposed_amt + sep_proposed_amt) as item_ttl_amt_3rd'),
                DB::raw('(oct_proposed_amt + nov_proposed_amt + dec_proposed_amt) as item_ttl_amt_4th'),

                DB::raw('(jan_proposed_amt + feb_proposed_amt + mar_proposed_amt + apr_proposed_amt + may_proposed_amt + jun_proposed_amt + jul_proposed_amt + aug_proposed_amt + sep_proposed_amt + oct_proposed_amt + nov_proposed_amt + dec_proposed_amt) as item_total_amt'),

                DB::raw('(jan_proposed_qty + feb_proposed_qty + mar_proposed_qty + apr_proposed_qty + may_proposed_qty + jun_proposed_qty + jul_proposed_qty + aug_proposed_qty + sep_proposed_qty + oct_proposed_qty + nov_proposed_qty + dec_proposed_qty) as item_total_qty'),

                DB::raw('((jan_proposed_qty + feb_proposed_qty + mar_proposed_qty + apr_proposed_qty+ may_proposed_qty + jun_proposed_qty + jul_proposed_qty + aug_proposed_qty + sep_proposed_qty + oct_proposed_qty + nov_proposed_qty + dec_proposed_qty) * unit_cost) as item_total_cost'))
            ->get()->keyBy('id')->toArray())->groupBy('classification.classification');

        $this->rowCount = $this->ppmpHeader->ppmpdetail()->count() +  ($ppmpDetailItems->count() * 2);
        $this->headerCount = $ppmpDetailItems->count();
        // Count per classification items
        $sql = collect(PpmpDetail::with('category' )
            ->with('classification' )
            ->where('ppmp_header_id', $this->q)
            ->select('id', 'ppmp_header_id', 'plan_control_no', 'item_id', 'unit_cost as item_unit_cost', 'procurement_mode_code', 'item_description as item', 'category_id', 'classification_id','unit_id as item_unit',
                'jan_proposed_amt as item_jan_amt', 'feb_proposed_amt as item_feb_amt', 'mar_proposed_amt as item_mar_amt', 'apr_proposed_amt as item_apr_amt',
                'may_proposed_amt as item_may_amt', 'jun_proposed_amt as item_jun_amt', 'jul_proposed_amt as item_jul_amt', 'aug_proposed_amt as item_aug_amt',
                'sep_proposed_amt as item_sep_amt', 'oct_proposed_amt as item_oct_amt', 'nov_proposed_amt as item_nov_amt', 'dec_proposed_amt as item_dec_amt',

                'jan_proposed_qty as item_jan_qty', 'feb_proposed_qty as item_feb_qty', 'mar_proposed_qty as item_mar_qty', 'apr_proposed_qty as item_apr_qty',
                'may_proposed_qty as item_may_qty', 'jun_proposed_qty as item_jun_qty', 'jul_proposed_qty as item_jul_qty', 'aug_proposed_qty as item_aug_qty',
                'sep_proposed_qty as item_sep_qty', 'oct_proposed_qty as item_oct_qty', 'nov_proposed_qty as item_nov_qty', 'dec_proposed_qty as item_dec_qty',

                DB::raw('(jan_proposed_amt + feb_proposed_amt + mar_proposed_amt + apr_proposed_amt + may_proposed_amt + jun_proposed_amt + jul_proposed_amt + aug_proposed_amt + sep_proposed_amt + oct_proposed_amt + nov_proposed_amt + dec_proposed_amt) as item_total_amt'),

                DB::raw('(jan_proposed_qty + feb_proposed_qty + mar_proposed_qty + apr_proposed_qty + may_proposed_qty + jun_proposed_qty + jul_proposed_qty + aug_proposed_qty + sep_proposed_qty + oct_proposed_qty + nov_proposed_qty + dec_proposed_qty) as item_total_qty'),

                DB::raw('((jan_proposed_qty + feb_proposed_qty + mar_proposed_qty + apr_proposed_qty+ may_proposed_qty + jun_proposed_qty + jul_proposed_qty + aug_proposed_qty + sep_proposed_qty + oct_proposed_qty + nov_proposed_qty + dec_proposed_qty) * unit_cost) as item_total_cost'))
            ->get());

        $classificationItemCount = $sql->groupBy('classification.classification')->map(function ($row) {
            return $row->count();
        });

        $this->classificationItemCount = $classificationItemCount->toArray();

//        dd($this->rowCount);

        return view('exports.vtt.ppmp_details', [
            'ppmpHeader' => $this->ppmpHeader,
            'PpmpDetailItems' => $ppmpDetailItems,
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

        $start = $this->rowStart;
        $cnt = 1;
        $totalItem = 0;
        $totalRow = $start;

        ///////////////////////////////////////////////////////////
        // Begin:: Categories and Subtotal Style
        ///////////////////////////////////////////////////////////

        foreach ($this->classificationItemCount  as $key => $value) {
            $cnt += 1;
            $totalItem += $value;
            $totalRow += ($value + 2);

            // Classification Style
            $sheet->getStyle('A'.($totalRow-($value+2)).':AO'.($totalRow-($value+2)))->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->getStyle('A'.($totalRow-($value+2)).':AO'.($totalRow-($value+2)))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ccecfd'],]);

            // SubTotal Style
            $sheet->getStyle('A'.($totalRow-1).':AO'.($totalRow-1))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'EAF2DE'],]);

        }

        ///////////////////////////////////////////////////////////
        // End:: Classification and Subtotal Style
        ///////////////////////////////////////////////////////////

        // Border Style
        $sheet->getStyle('A'.($start-4).':AO'.($totalRow))->applyFromArray($styleArray);

        $sheet->getStyle('B'.($start+1).':B'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.($start+1).':S'.$totalRow)->getAlignment()->setVertical('center');
        $sheet->getStyle('E'.($start+1).':F'.$totalRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $sheet->getStyle('D'.($start+1).':F'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H'.($start+1).':AO'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        //Proc. Method - Wrap and Horizontal Alignment
        $sheet->getStyle('G'.($start-2).':G'.$totalRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('G'.($start+1).':G'.$totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Grand total
        $sheet->getStyle('A'.($totalRow).':AO'.($totalRow))->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'fff4cc'],]);

        $sheet->setShowGridlines(false);
        $sheet->getPageSetup()->setFitToWidth(1);

    }

    public function drawings()
    {
        $drawings = [];

        $this->ppmpHeader = PpmpHeader::with('ppmpdetail', 'prepared', 'approved')->with('office')->find($this->q);

        if ($this->ppmpHeader->status == 4){
            $ppmpDetailItems = collect(PpmpDetail::with('category')
                ->with('classification' )
                ->with('items' )
                ->where('ppmp_header_id', $this->q)
                ->select('id', 'ppmp_header_id', 'category_id', 'classification_id')
                ->get()->keyBy('id')->toArray())->groupBy('classification.classification');

            $this->rowCount = $this->ppmpHeader->ppmpdetail()->count() +  ($ppmpDetailItems->count() * 2);
            $rowstart = ($this->rowStart ?? 0) + ($this->rowCount ?? 0) + 1;

            if(File::exists(public_path('storage/'.$this->ppmpHeader->prepared->signature))){
                $drawing = new Drawing();
                $drawing->setName('image');
                $drawing->setDescription('image');
                $drawing->setPath(public_path('storage/'.$this->ppmpHeader->prepared->signature));
                $drawing->setHeight(80);
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setCoordinates('B'.($rowstart));
                $drawings[] = $drawing;
            }

            if(File::exists(public_path('storage/'.$this->ppmpHeader->approved->signature))){
                $drawing = new Drawing();
                $drawing->setName('image');
                $drawing->setDescription('image');
                $drawing->setPath(public_path('storage/'.$this->ppmpHeader->approved->signature));
                $drawing->setHeight(80);
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setCoordinates('G'.($rowstart));
                $drawings[] = $drawing;
            }

//            {{public_path('storage/'.$header->approved->signature)
//            dd(public_path('storage/'.$this->ppmpHeader->approved->signature));
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('/demo1/media/logos/DepEd Seal.png'));
        $drawing->setHeight(90);
        $drawing->setWidth(90);
        $drawing->setCoordinates('A2');
        $drawings[] = $drawing;

        return $drawings;
    }
}
