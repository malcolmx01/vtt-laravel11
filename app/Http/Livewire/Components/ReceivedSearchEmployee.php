<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Vtt\Employee;

class ReceivedSearchEmployee extends Component
{
    const EVENT_VALUE_UPDATED = 'selected_received_by';

    public $value;
    public $placeholder;
    public $show;
    public $seId;
    public $search;
    public $itemSelected = [];

    public function mount($value = '', $placeholder = '', $show = ''){
        $this->value = $value;
        $this->show = $show;
        $this->placeholder = $placeholder;
        $this->seId = 'se-' . uniqid();
    }

    ////////////////////////////////////////////////////////////
    // Search and Attach Item
    ////////////////////////////////////////////////////////////

    public function searchSelectItem($employeeId)
    {
        $this->search = '';
        $this->emit(self::EVENT_VALUE_UPDATED, $employeeId ?? '');

    }

    public function render()
    {
        if(!empty($this->search)){
            $searchItems = Employee::
            with('position','office')
                ->where('first_name', 'LIKE' , '%'. $this->search.'%')
                ->orWhere('middle_name', 'LIKE' , '%'. $this->search.'%')
                ->orWhere('last_name', 'LIKE' , '%'. $this->search.'%')
                ->orWhereRaw("concat(first_name, ' ', last_name) like '%" .$this->search. "%' ")
                ->orWhereHas('position', function ($query) {
                    $query->where('positions.pos_name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('office', function ($query) {
                    $query->where('departments.dept_name', 'like', '%'.$this->search.'%');
                })
                /*->limit(10)*/
                ->get();
        }
        return view('livewire.components.search-employee',[
            'searchResultItems' => $searchItems ?? [],
        ]);
    }

}
