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
use App\Models\Vtt\Trip;
use App\Models\Vtt\Vehicle;
use App\Models\Vtt\DocStatus;

class VehiclesSetStatus extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'setstatus' => 'setstatus',
        'editstatus' => 'editdetails',
        SetbySearchEmployee::EVENT_VALUE_UPDATED,
    ];

    public $vehicle;
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
        $this->vehicle = new Vehicle();

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
            'vehicle.status_date'          => 'required|date',
            'vehicle.setby_remarks'        => 'nullable|string',
            'vehicle.status'               => 'required|numeric',
            'vehicle.setby'                => 'nullable|integer',
            'vehicle.setby_name'           => 'nullable|string',
            'vehicle.setby_designation_id' => 'nullable|integer',
            'vehicle.setby_designation'    => 'nullable|string',
            'vehicle.setby_office_id'      => 'nullable|integer',
            'vehicle.setby_office'         => 'nullable|string',
        ];
    }

    public function selected_set_by(Employee $employee){
        $this->vehicle->setby = $employee->id  ?? null;
        $this->vehicle->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->vehicle->setby_designation_id = $employee->position_id ?? null;
        $this->vehicle->setby_designation = $employee->position ?? null;
        $this->vehicle->setby_office_id = $employee->office->id ?? null;
        $this->vehicle->setby_office = $employee->office->dept_name ?? null;
    }

    public function clear_set_by(){
        $this->vehicle->setby = null;
        $this->vehicle->setby_name = null;
        $this->vehicle->setby_designation_id = null;
        $this->vehicle->setby_designation = null;
        $this->vehicle->setby_office_id = null;
        $this->vehicle->setby_office = null;
    }

    public function setstatus($data){
        $this->crud = 'create';
        $this->resetValidation();
        $this->vehicle = Vehicle::where('id', $data['id'])->first();
        $this->vehicle->status_date = $this->vehicle->status_date ? Carbon::parse($this->vehicle->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->vehicle->status = $this->vehicle->status ? $this->vehicle->status : 1;

        $this->setby = auth()->user()->info->employee_id ?? null;

        $employee = Employee::
        with('position','office')
            ->where('id', $this->setby)
            ->first();

        $this->vehicle->setby = $employee->id  ?? null;
        $this->vehicle->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->vehicle->setby_designation_id = $employee->position_id ?? null;
        $this->vehicle->setby_designation = $employee->position ?? null;
        $this->vehicle->setby_office_id = $employee->office->id ?? null;
        $this->vehicle->setby_office = $employee->office->dept_name ?? null;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->vehicle->status ?? '',
            'setby' => $this->setby ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');
    }

    public function render()
    {
        return view('livewire.vtt.vehicles.set-status');
    }

    public function store(){

        $this->validate();
        $this->vehicle->update();
        $this->alert('success', 'Vehicle Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->emit('updatestatus', $this->vehicle->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');
    }

    public function editdetails(Vehicle $Vehicle){
        $this->vehicle = $Vehicle;
        $this->crud = 'edit';
        $this->disable = false;

        $this->vehicle->status_date = $Vehicle->status_date ? Carbon::parse($Vehicle->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->vehicle->status = $this->vehicle->status ? $this->vehicle->status : 1;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->vehicle->status ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');

    }

    public function update(Vehicle $Vehicle){

        $this->validate();
        $this->vehicle->update();

        $this->alert('success', 'Vehicle Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully Updated!',
        ]);
        $this->emit('updatestatus', $this->vehicle->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');

    }

}
