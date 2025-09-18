<?php

namespace App\Exports\Pms;

use App\Models\Vtt\Agenda;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

//class AgendasExport implements FromView, ShouldAutoSize, WithColumnWidths
class BidsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

    public function view(): View
    {
        $search = $this->q;

        $projects =  Agenda::search($this->q)
            ->with('service')
            ->orWhereHas('service', function ($q) use ($search) {
                $q->where('services.services', 'like', '%'.$search.'%');
            })->get();

        return view('exports.pms.projects_archive', [
            'projects' => $projects
        ]);

    }
}
