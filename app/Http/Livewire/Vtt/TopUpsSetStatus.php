<?php

namespace App\Http\Livewire\Vtt;
use Illuminate\Support\Facades\Auth;
//////////////////////////////
// Include Plugins and Others
//////////////////////////////

use Livewire\Component;
use Illuminate\Validation\Rule;
use DB;
use Exception;
use File;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Livewire\Components\SetbySearchEmployee;

//////////////////////////////
// Include Model
//////////////////////////////

use App\Models\Vtt\Fund;
use App\Models\Vtt\Department;
use App\Models\Vtt\Item;
use App\Models\Vtt\ProcurementMode;
use App\Models\Vtt\Employee;
use App\Models\Vtt\PpmpStatus;
use App\Models\Vtt\TopUp;
use App\Models\Vtt\DocStatus;

class TopUpsSetStatus extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'setstatus' => 'setstatus',
        'editstatus' => 'editdetails',
        SetbySearchEmployee::EVENT_VALUE_UPDATED,
    ];

    public $topup;
    public $listOfDepartment, $ppmpstatus, $disable = false;
    public $setby, $setby_name, $setby_designation_id, $setby_designation, $setby_office_id, $setby_office;
    public $crud, $maximize;
    public $setbyId;
    public $DocStatus;

    public function mount()
    {
        $this->DocStatus = DocStatus::all();
        $this->setbyId = Str::random();
    }

    public function maximize()
    {
        if (empty($this->maximize)) {
            $this->maximize = 'modal-fullscreen';
        } else {
            $this->maximize = '';
        }
    }

    public function resetVariables()
    {
        $this->topup = new TopUp();

        $defaultVariable = [
            'maximize',
            'disable',
            'crud',
        ];
        $this->reset($defaultVariable);
        $this->resetValidation();
    }

    protected function rules(){
        return [
            'topup.status_date'          => 'required|date',
            'topup.setby_remarks'        => 'nullable|string',
            'topup.status'               => 'required|numeric',
            'topup.setby'                => 'nullable|integer',
            'topup.setby_name'           => 'nullable|string',
            'topup.setby_designation_id' => 'nullable|integer',
            'topup.setby_designation'    => 'nullable|string',
            'topup.setby_office_id'      => 'nullable|integer',
            'topup.setby_office'         => 'nullable|string',
        ];
    }

    public function selected_set_by(Employee $employee){
        $this->topup->setby = $employee->id  ?? null;
        $this->topup->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->topup->setby_designation_id = $employee->position_id ?? null;
        $this->topup->setby_designation = $employee->position ?? null;
        $this->topup->setby_office_id = $employee->office->id ?? null;
        $this->topup->setby_office = $employee->office->dept_name ?? null;
    }

    public function clear_set_by(){
        $this->topup->setby = null;
        $this->topup->setby_name = null;
        $this->topup->setby_designation_id = null;
        $this->topup->setby_designation = null;
        $this->topup->setby_office_id = null;
        $this->topup->setby_office = null;
    }

    public function setstatus($data){
        $this->crud = 'create';
        $this->resetValidation();
        $this->topup = TopUp::where('id', $data['id'])->first();
        $this->topup->status_date = $this->topup->status_date ? Carbon::parse($this->topup->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->topup->status = $this->topup->status ? $this->topup->status : 1;

        $this->setby = auth()->user()->info->employee_id ?? null;

        $employee = Employee::
        with('position','office')
            ->where('id', $this->setby)
            ->first();

        $this->topup->setby = $employee->id  ?? null;
        $this->topup->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->topup->setby_designation_id = $employee->position_id ?? null;
        $this->topup->setby_designation = $employee->position ?? null;
        $this->topup->setby_office_id = $employee->office->id ?? null;
        $this->topup->setby_office = $employee->office->dept_name ?? null;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->topup->status ?? '',
            'setby' => $this->setby ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');
    }

    public function render()
    {
        return view('livewire.vtt.topups.set-status');
    }

    public function store(){

        $this->validate();
        $this->topup->update();
        $this->alert('success', 'TopUp Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->emit('updatestatus', $this->topup->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');
    }

    public function editdetails(TopUp $TopUp){
        $this->topup = $TopUp;
        $this->crud = 'edit';
        $this->disable = false;

        $this->topup->status_date = $TopUp->status_date ? Carbon::parse($TopUp->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->topup->status = $this->topup->status ? $this->topup->status : 1;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->topup->status ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');

    }

    public function update(TopUp $TopUp){

        $this->validate();
        $this->topup->update();

        $this->alert('success', 'TopUp Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully Updated!',
        ]);
        $this->emit('updatestatus', $this->topup->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');

    }

}
