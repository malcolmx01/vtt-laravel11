<?php

namespace App\Exports\Pims;

use App\Models\Vtt\IM;
use App\Models\Vtt\Item;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
//use Maatwebsite\Excel\Concerns\FromQuery;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;//sheet
use Maatwebsite\Excel\Concerns\WithStyles;// modelling  q
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

//use PhpOffice\PhpSpreadsheet\Style\
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


//class ItemsExport implements FromQuery
class IMsExport implements FromView, ShouldAutoSize, WithColumnWidths, WithEvents,  WithStyles
{
    use Exportable;
    public $recordCount;

    public function __construct(string $query, int $selectedOffice)
    {
        $this->q = $query;
        $this->office = $selectedOffice;
    }

    public function collection()
    {
        return IM::all();
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
        $departmentId = $this->office;

        $itemHeaders = Item::searchSLC($search)
            ->WhereHas('bi_details_item.biheader', function ($query) use ($departmentId) {
                if(!empty($departmentId)){
                    $query->where('office_id', $departmentId);
                }
                $query->where('status',5);
            })

            ->orWhereHas('iar_details_item.iarheader', function ($query) use ($search, $departmentId) {
                if(!empty($departmentId)){
                    $query->where('requisitioning_office', $departmentId);
                }

                $query->where('status',5)
                    ->where('items.category_id',1)
                    ->where('items.status',1);

                if(!empty($search)) {

                    $search_field = explode(" ", $search);
                    foreach ($search_field as $search) {
                        // just put in an array
                    }

                    $search_field_ctr = count($search_field);

                    if($search_field_ctr == 1) {
                        $query->where(function ($query) use ($search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                        });
                    }
                    if($search_field_ctr == 2) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%');
                        });
                    }if($search_field_ctr == 3) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');$query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->where('item', 'like', '%'.$search_field[2].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%')
                                ->Where('description', 'like', '%'.$search_field[2].'%');
                        });
                    }if($search_field_ctr == 4) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->where('item', 'like', '%'.$search_field[2].'%')
                                ->where('item', 'like', '%'.$search_field[3].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%')
                                ->Where('description', 'like', '%'.$search_field[2].'%')
                                ->Where('description', 'like', '%'.$search_field[3].'%');
                        });
                    }if($search_field_ctr > 4) {
                        $query->where(function ($query) use ($search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                        });
                    }
                }
            })
            ->orWhereHas('ris_details_item.risheader', function ($query) use ($search, $departmentId) {
                if(!empty($departmentId)){
                    $query->where('office_id', $departmentId);
                }

                $query->where('status',5)
                    ->where('items.category_id',1)
                    ->where('items.status',1);

                if(!empty($search)) {

                    $search_field = explode(" ", $search);
                    foreach ($search_field as $search) {
                        // just put in an array
                    }

                    $search_field_ctr = count($search_field);

                    if($search_field_ctr == 1) {
                        $query->where(function ($query) use ($search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                        });
                    }
                    if($search_field_ctr == 2) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%');
                        });
                    }if($search_field_ctr == 3) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');$query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->where('item', 'like', '%'.$search_field[2].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%')
                                ->Where('description', 'like', '%'.$search_field[2].'%');
                        });
                    }if($search_field_ctr == 4) {
                        $query->where(function ($query) use ($search_field, $search, $departmentId){
                            $query->where('item', 'like', '%'.$search_field[0].'%')
                                ->where('item', 'like', '%'.$search_field[1].'%')
                                ->where('item', 'like', '%'.$search_field[2].'%')
                                ->where('item', 'like', '%'.$search_field[3].'%')
                                ->orWhere('description', 'like', '%'.$search_field[0].'%')
                                ->Where('description', 'like', '%'.$search_field[1].'%')
                                ->Where('description', 'like', '%'.$search_field[2].'%')
                                ->Where('description', 'like', '%'.$search_field[3].'%');
                        });
                    }if($search_field_ctr > 4) {
                        $query->where(function ($query) use ($search, $departmentId){
                            $query->where('item', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                        });
                    }
                }
            })

            ->withSum(['iar_details_item' => function ($query) use ($departmentId) {
                $query->whereHas('iarheader', function ($query) use ($departmentId){
                    if(!empty($departmentId)){
                        $query->where('status',5)
                            ->where('requisitioning_office', $departmentId);
                    }else{
                        $query->where('status',5);
                    }
                });
            }],'quantity_approved')
            ->withSum(['ris_details_item' => function ($query) use ($departmentId){
                $query->whereHas('risheader', function ($query) use ($departmentId){
                    if(!empty($departmentId)){
                        $query->where('status',5)
                            ->where('office_id', $departmentId);
                    }else{
                        $query->where('status',5);
                    }
                });
            }], 'issued_quantity')
            ->withSum(['bi_details_item' => function ($query) use ($departmentId){
                $query->whereHas('biheader', function ($query) use ($departmentId){
                    if(!empty($departmentId)){
                        $query->where('status',5)
                            ->where('office_id', $departmentId)
                            ->where('trans_type',15);
                    }else{
                        $query->where('status',5)
                            ->where('trans_type',15);
                    }
                });
            }], 'issued_qty')
            ->withSum(['bi_details_item' => function ($query) use ($departmentId){
                $query->whereHas('biheader', function ($query) use ($departmentId){
                    if(!empty($departmentId)){
                        $query->whereIn('status',[4,5])
                            ->where('office_id', $departmentId)
                            ->where('trans_type',1);
                    }else{
                        $query->whereIn('status',[4,5])
                            ->where('trans_type',1);
                    }
                });
            }], 'on_hand_qty')->get();

        $this->recordCount = $itemHeaders->count();

        return view('exports.vtt.IMs_archive', [
            'items' => $itemHeaders
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
        $sheet->getStyle('A1:N'.$this->recordCount+1)->getAlignment()->setVertical('top');
        $sheet->getStyle('A1:N'.$this->recordCount+1)->applyFromArray($styleArray);

    }
}
