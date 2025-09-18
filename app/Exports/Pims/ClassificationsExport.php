<?php

namespace App\Exports\Pims;

use App\Models\Vtt\Classification;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
//use Maatwebsite\Excel\Concerns\WithColumnWidths;


class ClassificationsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

    public function view(): View
    {
        $search = $this->q;

        $classifications =  Classification::search($this->q)
            ->with('category')
            ->orWhereHas('category', function($q) use ($search){
                $q->select('category');
                $q->where('category', 'like', '%'.$search.'%');
            })->get();

        return view('exports.vtt.classification_archive', [
            'classifications' => $classifications
        ]);

    }
}
