<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Vtt\Supplier;

class SearchSupplier extends Component
{
    const EVENT_VALUE_UPDATED = 'selected_supplier';

    public $value;
    public $placeholder;
    public $show;
    public $ssId;
    public $search;
    public $itemSelected = [];

    public function mount($value = '', $placeholder = '', $show = ''){
        $this->value = $value;
        $this->show = $show;
        $this->placeholder = $placeholder;
        $this->ssId = 'ss-' . uniqid();
    }

    ////////////////////////////////////////////////////////////
    // Search and Attach Item
    ////////////////////////////////////////////////////////////

    public function searchSelectItem($supplierId)
    {
        $this->search = '';
        $this->emit(self::EVENT_VALUE_UPDATED, $supplierId ?? '');

    }

    public function render()
    {
        $keywords = $this->search;
        if(!empty($this->search)){
            $searchItems = Supplier::
            where('supplier', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('address1', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('contact_person', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('telno', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('mobile_no', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('email', 'LIKE' , '%'. $this->search.'%')
            ->orWhere('website', 'LIKE' , '%'. $this->search.'%')
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
        return view('livewire.components.search-supplier',[
            'searchResultItems' => $searchItems ?? [],
        ]);
    }

}
