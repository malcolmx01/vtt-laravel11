<?php

namespace App\Exports\Pims;

use App\Models\Vtt\Item;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;//sheet
use Maatwebsite\Excel\Concerns\WithStyles;// modelling  q
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

//use PhpOffice\PhpSpreadsheet\Style\
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


//class ItemsExport implements FromQuery
class SLCsExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles
{
    use Exportable;
    public $recordCount;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

    public function collection()
    {
        return Item::all();
    }

    public function columnWidths(): array
    {
        return [
            'B' => 40,
            'C' => 80,
            'D' => 100,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:AA1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);
            },
        ];
    }


    public function view(): View
    {

        $search = $this->q;

        $items =  Item::search($this->q)
            ->with('category')
            ->with('classification')
            ->with('sub_classification')
            ->orWhereHas('category', function ($q) use ($search) {
                $q->where('categories.category', 'like', '%'.$search.'%');
            })
            ->orWhereHas('classification', function ($q) use ($search) {
                $q->where('classifications.classification', 'like', '%'.$search.'%');
            })->get();

        $this->recordCount = $slc->count();

        return view('exports.vtt.slc_archive', [
            'slc' => $slc
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

        $sheet->getStyle('C1:C'.$this->recordCount+1)->getAlignment()->setWrapText(true);
        $sheet->getStyle('D1:D'.$this->recordCount+1)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:AA'.$this->recordCount+1)->getAlignment()->setVertical('top');
        $sheet->getStyle('A1:AA'.$this->recordCount+1)->applyFromArray($styleArray);

    }
}
