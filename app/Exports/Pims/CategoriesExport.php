<?php

namespace App\Exports\Pims;

use App\Models\Vtt\Category;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;


class CategoriesExport implements FromView, ShouldAutoSize, WithColumnWidths, WithBackgroundColor
{
    use Exportable;

    public function __construct(string $query)
    {
        $this->q = $query;
    }

    public function backgroundColor()
    {
        // Return RGB color code.
        return '000000';

        // Return a Color instance. The fill type will automatically be set to "solid"
        return new Color(Color::COLOR_BLUE);

        // Or return the styles array
        return [
            'fillType'   => Fill::FILL_GRADIENT_LINEAR,
            'startColor' => ['argb' => Color::COLOR_RED],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'D' => 100,
            'E' => 100,
        ];
    }

    public function view(): View
    {

        $categories =  Category::search($this->q)
            ->select(
                'id',
                'code',
                'category',
                'description',
                'details',
                'access_role',
                'group',
                'status'
            )
            ->with('classification')->get();

        return view('exports.vtt.categories_archive', [
            'categories' => $categories
        ]);

    }

}
