<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Vtt\FuelDepot;

class SearchFueldepot extends Component
{
    const EVENT_VALUE_UPDATED = 'selected_fuel_depot';

    public $value;
    public $placeholder;
    public $show;
    public $sfId;
    public $search;
    public $itemSelected = [];

    public function mount($value = '', $placeholder = '', $show = ''){
        $this->value = $value;
        $this->show = $show;
        $this->placeholder = $placeholder;
        $this->sfId = 'sf-' . uniqid();
    }

    ////////////////////////////////////////////////////////////
    // Search and Attach Item
    ////////////////////////////////////////////////////////////

    public function searchSelectItem($fueldepotId)
    {
        $this->search = '';
        $this->emit(self::EVENT_VALUE_UPDATED, $fueldepotId ?? '');

    }

    public function render()
    {
        $keywords = $this->search;
        if(!empty($this->search)){
            $searchItems = FuelDepot::
            where('fuel_depot', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('fuel_depot_location', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('fuel_depot_provider_name', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('fuel_depot_brand', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('remarks', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('status', 'LIKE' , '%'. $this->search.'%')
//            ->orWhereRaw("concat(first_name, ' ', last_name) like '%" .$this->search. "%' ")
//            ->orWhereHas('position', function ($query) {
//                $query->where('positions.pos_name', 'like', '%'.$this->search.'%');
//            })
//            ->orWhereHas('office', function ($query) {
//                $query->where('departments.dept_name', 'like', '%'.$this->search.'%');
//            })
            /*->limit(10)*/
            ->get();
//            ->get()
//            ->map(function($row) use ($keywords) {
//                $row->first_name = preg_replace('/(' . $keywords . ')/i', "<b class='text-danger'>$1</b>", $row->first_name);
//                $row->last_name = preg_replace('/(' . $keywords . ')/i', "<b class='text-danger'>$1</b>", $row->last_name);
//                return $row;
//            });
        }
        return view('livewire.components.search-fueldepot',[
            'searchResultItems' => $searchItems ?? [],
        ]);
    }

}
