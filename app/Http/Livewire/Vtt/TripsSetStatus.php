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
use App\Models\Vtt\DocStatus;

class TripsSetStatus extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'setstatus' => 'setstatus',
        'editstatus' => 'editdetails',
        SetbySearchEmployee::EVENT_VALUE_UPDATED,
    ];

    public $trip;
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
        $this->trip = new Trip();

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
            'trip.status_date'          => 'required|date',
            'trip.setby_remarks'        => 'nullable|string',
            'trip.status'               => 'required|numeric',
            'trip.setby'                => 'nullable|integer',
            'trip.setby_name'           => 'nullable|string',
            'trip.setby_designation_id' => 'nullable|integer',
            'trip.setby_designation'    => 'nullable|string',
            'trip.setby_office_id'      => 'nullable|integer',
            'trip.setby_office'         => 'nullable|string',
        ];
    }

    public function selected_set_by(Employee $employee){
        $this->trip->setby = $employee->id  ?? null;
        $this->trip->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->trip->setby_designation_id = $employee->position_id ?? null;
        $this->trip->setby_designation = $employee->position ?? null;
        $this->trip->setby_office_id = $employee->office->id ?? null;
        $this->trip->setby_office = $employee->office->dept_name ?? null;
    }

    public function clear_set_by(){
        $this->trip->setby = null;
        $this->trip->setby_name = null;
        $this->trip->setby_designation_id = null;
        $this->trip->setby_designation = null;
        $this->trip->setby_office_id = null;
        $this->trip->setby_office = null;
    }

    public function setstatus($data){
        $this->crud = 'create';
        $this->resetValidation();
        $this->trip = Trip::where('id', $data['id'])->first();
        $this->trip->status_date = $this->trip->status_date ? Carbon::parse($this->trip->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->trip->status = $this->trip->status ? $this->trip->status : 1;

        $this->setby = auth()->user()->info->employee_id ?? null;

        $employee = Employee::
        with('position','office')
            ->where('id', $this->setby)
            ->first();

        $this->trip->setby = $employee->id  ?? null;
        $this->trip->setby_name = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->trip->setby_designation_id = $employee->position_id ?? null;
        $this->trip->setby_designation = $employee->position ?? null;
        $this->trip->setby_office_id = $employee->office->id ?? null;
        $this->trip->setby_office = $employee->office->dept_name ?? null;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->trip->status ?? '',
            'setby' => $this->setby ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');
    }

    public function render()
    {
        return view('livewire.vtt.trips.set-status');
    }

    public function store(){

        $this->validate();
        $this->trip->update();
        $this->alert('success', 'Trip Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->emit('updatestatus', $this->trip->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');
    }

    public function editdetails(Trip $Trip){
        $this->trip = $Trip;
        $this->crud = 'edit';
        $this->disable = false;

        $this->trip->status_date = $Trip->status_date ? Carbon::parse($Trip->status_date)->format('Y-m-d h:i:s') : Carbon::now()->format('Y-m-d h:i:s');
        $this->trip->status = $this->trip->status ? $this->trip->status : 1;

        $this->emit('setby_loadDefaultValue', [
            'status' => $this->trip->status ?? '',
        ]);

        $this->dispatchBrowserEvent('openModal_setstatus');

    }

    public function update(Trip $Trip){

        $this->validate();
        $this->trip->update();

        $this->alert('success', 'Trip Set Status', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully Updated!',
        ]);
        $this->emit('updatestatus', $this->trip->id);
        $this->dispatchBrowserEvent('closeModal_setstatus');

    }

}
