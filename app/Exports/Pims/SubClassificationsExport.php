<?php

namespace App\Exports\Pims;

use App\Models\Vtt\Sub_classification;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SubClassificationsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

    public function view(): View
    {

        $search = $this->q;

        $subClassifications =  Sub_classification::search($this->q)
            ->with('classification')
            ->with('category')
            ->orWhereHas('classification', function($q) use ($search){
                $q->where('classifications.classification', 'like', '%'.$search.'%');
            })
            ->orWhereHas('classification.category', function($q) use ($search){
                $q->where('categories.category', 'like', '%'.$search.'%');
            })->get();

        return view('exports.vtt.sub_classification_archive', [
            'subclassifications' => $subClassifications
        ]);

    }

}
