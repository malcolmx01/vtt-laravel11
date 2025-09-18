<?php

namespace App\Exports\Pms;

use App\Models\Pms\Project;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

//class ProjectsExport implements FromView, ShouldAutoSize, WithColumnWidths
class ProjectsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

//    public function query()
//    {
//        $search = $this->q;
//
//        return Project::query()
//            ->with('service')
//            ->where('project', 'like', '%'.$this->q .'%')
//            ->orWhere('description', 'like', '%'.$this->q .'%')
//            ->orWhere('status', 'like', '%'.$this->q .'%')
//            ->orWhereHas('service', function($q) use ($search){
//                $q->where('services', 'like', '%'.$search.'%');
//            });
//    }

//    public function columnWidths(): array
//    {
//        return [
//            'B' => 40,
//            'C' => 80,
//            'D' => 100,
//        ];
//    }

    public function view(): View
    {
        $search = $this->q;

        $projects =  Project::search($this->q)
            ->with('service')
            ->orWhereHas('service', function ($q) use ($search) {
                $q->where('services.services', 'like', '%'.$search.'%');
            })->get();

        return view('exports.pms.projects_archive', [
            'projects' => $projects
        ]);

    }
}
