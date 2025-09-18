<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class TrixEditor extends Component
{
    const EVENT_VALUE_UPDATED = 'trix_editor_value_updated';

    public $value;
    public $trixId;

    protected $listeners = ['trixValue' => 'updatedValue'];

    public function mount($value = ''){
        $this->value = $value;
        $this->trixId = 'trix-' . uniqid();
    }

    public function updatedValue($value){
        $this->emit(self::EVENT_VALUE_UPDATED, $this->value);
    }

    public function render()
    {
        return view('livewire.components.trix-editor');
    }

}
