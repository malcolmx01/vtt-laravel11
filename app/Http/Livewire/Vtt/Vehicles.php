<?php

namespace App\Http\Livewire\Vtt;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

//////////////////////////////
// Include Plugins and Others
//////////////////////////////

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DB;
use Exception;
use File;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Livewire\Components\SearchEmployee;
use App\Http\Livewire\Components\ApprovedSearchEmployee;

//////////////////////////////
// Include Model
//////////////////////////////

use App\Models\Vtt\Vehicle;
use App\Models\Vtt\Topup;
use App\Models\Vtt\Trip;
use App\Models\Vtt\Department;
use App\Models\Vtt\Employee;
use App\Models\Vtt\Attachment;
use App\Models\Vtt\DocStatus;
use App\Models\Vtt\ModeOfAcquisition;

//////////////////////////////
// Include Export
//////////////////////////////

//use App\Exports\Pims\PRExport;
//use App\Exports\Pims\PRPrintableExport;

class Vehicles extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';


    //////////////////////////////
    // Model
    //////////////////////////////

    public $vehicle;
    public $addItemUniqid, $listOfDepartment, $listOfEmployee, $VehicleCollection, $disable = false;
    public $crud;
    public $DocStatus, $setstatusid, $ModeAcquisition;
    public $disableeditdetails = false;

    public $itemSearch = '';
    public $itemSelected = [];
    public $itemCollection;
    public $RisDetailItems;
    public $seId;

    public $input = [];
    public $i = 1;
    public $attachment, $filename, $deleteAttachment, $attachmentList = [];

    //////////////////////////////
    // Pagination Variable
    //////////////////////////////

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;

    //////////////////////////////
    // Other Variable
    //////////////////////////////

    public $selected_id, $deleteId, $deletedRow, $showid, $createForm;
    public $showDetails = false, $editDetails, $maximize, $show_id;

    protected $listeners = [
        'CreateNewRecord' => 'create',
        'delete',
        'updateAttachDetails',
        'refreshParent' => '$refresh',
        'deleteAttachmentConfirmed',
        SearchEmployee::EVENT_VALUE_UPDATED,
        ApprovedSearchEmployee::EVENT_VALUE_UPDATED,
        'updatestatus',
    ];

    protected $rules = [
        'vehicle.vehicle_plate_no'                   => 'required|string',
        'vehicle.model'                   => 'required|string',
        'vehicle.make'                   => 'required|string',
        'vehicle.chassis_no'                   => 'required|string',
        'vehicle.engine_no'                   => 'required|string',
        'vehicle.OR_no'                   => 'required|string',
        'vehicle.CR_no'                   => 'required|string',
        'vehicle.color'                   => 'required|string',
        'vehicle.conduction_sticker'                   => 'required|string',
        'vehicle.year'             => 'required|integer',
        'vehicle.person_in_charge_id'             => 'required|integer',
        'vehicle.person_in_charge_name'           => 'nullable|string',
        'vehicle.person_in_charge_designation_id' => 'nullable|integer',
        'vehicle.person_in_charge_designation'    => 'nullable|string',
        'vehicle.person_in_charge_office_id'      => 'nullable|integer',
        'vehicle.person_in_charge_office'    => 'nullable|string',
        'vehicle.employee_no'                     => 'nullable|string',
        'vehicle.remarks'                         => 'string|nullable',
        'vehicle.status' => 'nullable|integer',

        'vehicle.mode_of_acquisition'             => 'nullable|integer',
        'vehicle.supplier_origin'             => 'nullable|string',
        'vehicle.assigned_office'             => 'nullable|string',
        'vehicle.user_id'             => 'required|integer',
    ];

    protected $messages = [
        'trip.person_in_charge_id.required' => 'Person in Charge cannot be empty.',

        'vehicle.year.required' => 'Year model cannot be empty.',
        'vehicle.make.required' => 'Make cannot be empty.',
        'vehicle.chassis_no.required' => 'Chassis No. cannot be empty.',
        'vehicle.engine_no.required' => 'Engine No. cannot be empty.',
        'vehicle.OR_no.required' => 'LTO Official Receipt No. cannot be empty.',
        'vehicle.CR_no.required' => 'LTO Certificate of Registration No. cannot be empty.',
        'vehicle.color.required' => 'Color cannot be empty.',

    ];

    public function mount()
    {
        $this->seId = Str::random();
        $this->addItemUniqid = Str::random();
        $this->VehicleCollection = Vehicle::all();
        $this->DocStatus = DocStatus::all();
        $this->setstatusid = Str::random();
        $this->ModeAcquisition = ModeOfAcquisition::all();
    }

    public function updatingSearch() { $this->resetPage(); }


    public function search_employee_value_updated(Employee $employee){
        $this->vehicle->person_in_charge_id = $employee->id  ?? null;
        $this->vehicle->person_in_charge_name  = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->vehicle->person_in_charge_designation_id = $employee->position_id ?? null;
        $this->vehicle->person_in_charge_designation = $employee->position ?? null;
        $this->vehicle->person_in_charge_office_id = $employee->office->id ?? null;
        $this->vehicle->person_in_charge_office = $employee->office->dept_name ?? null;
        $this->vehicle->employee_no = $employee->employee_no ?? null;
    }

    public function clear_employee(){
        $this->vehicle->person_in_charge_id = null;
        $this->vehicle->person_in_charge_name = null;
        $this->vehicle->person_in_charge_designation_id = null;
        $this->vehicle->person_in_charge_designation = null;
        $this->vehicle->person_in_charge_office_id = null;
        $this->vehicle->person_in_charge_office = null;
        $this->vehicle->employee_no = null;
    }

    public function maximize()
    {
        if (empty($this->maximize)) {
            $this->maximize = 'modal-fullscreen';
        } else {
            $this->maximize = '';
        }
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->input ,$i);
    }

    public function remove($i)
    {
        unset($this->input[$i]);
        if(!empty($this->attachment)) unset($this->attachment[$i]);
        if(!empty($this->filename)) unset($this->filename[$i]);
    }

    public function resetVariables()
    {
        $defaultVariable = [
            'maximize',
            'showDetails',
            'disable',
            'crud',
        ];
        $this->reset($defaultVariable);
        $this->addItemUniqid = Str::random();
        $this->VehicleCollection = Vehicle::all();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.vtt.vehicles.index', [
            'vehicles' => Vehicle::search($this->search)
                ->with('docstatus')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }


    ////////////////////////////////////////////////////////////
    // Open/Create Vehicle Modal
    ////////////////////////////////////////////////////////////

    public function create()
    {
        $this->vehicle = new Vehicle();
        $this->vehicle->status = 1;
        $this->vehicle->user_id = auth()->id();
        $this->crud = 'create';
        $this->input = [];
        $this->dispatchBrowserEvent('openFormModal');

    }

    ////////////////////////////////////////////////////////////
    // Save Vehicle
    ////////////////////////////////////////////////////////////

    public function store()
    {
        $dynamicInput = [];

        if(!empty($this->input)){
            array_push($dynamicInput, ['attachment.*' => 'required|mimes:jpeg,png,jpg,gif,svg,xls,xlsx,doc,docx,pdf,shp|max:12240', 'filename.*' => 'required']);
        }
        foreach ($this->input as $key => $value) {
            array_push($dynamicInput, ['attachment.' . $value => 'required|mimes:jpeg,png,jpg,gif,svg,xls,xlsx,doc,docx,pdf,shp|max:12240', 'filename.' . $value => 'required']);
        }

        $mergeResult = call_user_func_array('array_merge', $dynamicInput);

        $staticInput = [
            'vehicle.vehicle_plate_no'                   => 'required|string',
            'vehicle.model'                   => 'required|string',
            'vehicle.make'                   => 'required|string',
            'vehicle.chassis_no'                   => 'required|string',
            'vehicle.engine_no'                   => 'required|string',
            'vehicle.OR_no'                   => 'required|string',
            'vehicle.CR_no'                   => 'required|string',
            'vehicle.color'                   => 'required|string',
            'vehicle.conduction_sticker'                   => 'required|string',
            'vehicle.year'                      => 'required|integer',
            'vehicle.mode_of_acquisition'             => 'nullable|integer',
            'vehicle.supplier_origin'             => 'nullable|string',
            'vehicle.assigned_office'             => 'nullable|string',
            'vehicle.remarks'                         => 'string|nullable',
            'vehicle.status' => 'nullable|integer',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);
//      $this->validate();
        $this->vehicle->save();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->vehicle->id,
                'attachable_type' => 'App\Models\Vtt\Vehicle',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('trip_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }
        //Reset attachment upload
        $this->input = [];

        $this->alert('success', 'Vehicle', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->dispatchBrowserEvent('closeFormModal');
    }

    ////////////////////////////////////////////////////////////
    // Showing Vehicle Details
    ////////////////////////////////////////////////////////////

    public function show(Vehicle $vehicle)
    {

        if ($vehicle->status > 1) {
            $this->disableeditdetails = true;
        }

        $this->vehicle = $vehicle;

        $this->vehicle->vehicle_plate_no = $vehicle->vehicle_plate_no ? $vehicle->vehicle_plate_no : '';
        $this->vehicle->model = $vehicle->model ? $vehicle->model : '';
        $this->vehicle->make = $vehicle->make ? $vehicle->make : '';
        $this->vehicle->chassis_no = $vehicle->chassis_no ? $vehicle->chassis_no : '';
        $this->vehicle->engine_no = $vehicle->engine_no ? $vehicle->engine_no : '';
        $this->vehicle->OR_no = $vehicle->OR_no ? $vehicle->OR_no : '';
        $this->vehicle->CR_no = $vehicle->CR_no ? $vehicle->CR_no : '';
        $this->vehicle->color = $vehicle->color ? $vehicle->color : '';
        $this->vehicle->conduction_sticker = $vehicle->conduction_sticker ? $vehicle->conduction_sticker : '';
        $this->vehicle->year = $vehicle->year ? $vehicle->year : '';

        $this->vehicle->mode_of_acquisition = $vehicle->mode_of_acquisition ? $vehicle->mode_of_acquisition : '';
        $this->vehicle->supplier_origin = $vehicle->supplier_origin ? $vehicle->supplier_origin : '';
        $this->vehicle->assigned_office = $vehicle->assigned_office ? $vehicle->assigned_office : '';

        $this->vehicle->status = $this->vehicle->status ? $this->vehicle->status : 1; //Draft
        $this->attachmentList = Attachment::where('attachable_id',$vehicle->id)->where('attachable_type', 'App\Models\Vtt\Vehicle')->get();
        $this->disable = true;
        $this->crud = 'show';
        $this->emit('loadDefaultValueAndDisable', [
            'person_in_charge_id' => $this->vehicle->person_in_charge_id ?? '',
            'remarks' => $this->vehicle->remarks ?? '',
        ]);

        $this->dispatchBrowserEvent('openFormModal');
//        $this->dispatchBrowserEvent('scrollToBottom');
    }

    ////////////////////////////////////////////////////////////
    // Edit Vehicle Details
    ////////////////////////////////////////////////////////////

    public function edit(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->disable = false;
        $this->crud = 'edit';
        $this->vehicle->user_id = auth()->id();

        $this->vehicle->vehicle_plate_no = $vehicle->vehicle_plate_no ? $vehicle->vehicle_plate_no : '';
        $this->vehicle->model = $vehicle->model ? $vehicle->model : '';
        $this->vehicle->make = $vehicle->make ? $vehicle->make : '';
        $this->vehicle->chassis_no = $vehicle->chassis_no ? $vehicle->chassis_no : '';
        $this->vehicle->engine_no = $vehicle->engine_no ? $vehicle->engine_no : '';
        $this->vehicle->OR_no = $vehicle->OR_no ? $vehicle->OR_no : '';
        $this->vehicle->CR_no = $vehicle->CR_no ? $vehicle->CR_no : '';
        $this->vehicle->color = $vehicle->color ? $vehicle->color : '';
        $this->vehicle->conduction_sticker = $vehicle->conduction_sticker ? $vehicle->conduction_sticker : '';
        $this->vehicle->year = $vehicle->year ? $vehicle->year : '';
        $this->vehicle->mode_of_acquisition = $vehicle->mode_of_acquisition ? $vehicle->mode_of_acquisition : '';
        $this->vehicle->supplier_origin = $vehicle->supplier_origin ? $vehicle->supplier_origin : '';
        $this->vehicle->assigned_office = $vehicle->assigned_office ? $vehicle->assigned_office : '';

        $this->vehicle->status = $this->vehicle->status ? $this->vehicle->status : 1; //Draft

        $this->attachmentList = Attachment::where('attachable_id',$vehicle->id)->where('attachable_type', 'App\Models\Vtt\Vehicle')->get();

        $this->emit('loadDefaultValue', [
            'person_in_charge_id' => $this->vehicle->person_in_charge_id ?? '',
            'remarks' => $this->vehicle->remarks ?? '',
        ]);

        $this->dispatchBrowserEvent('openFormModal');
//        $this->dispatchBrowserEvent('scrollToBottom');

    }

    ////////////////////////////////////////////////////////////
    // Updated Vehicle Details
    ////////////////////////////////////////////////////////////

    public function update()
    {

        $dynamicInput = [];

        if(!empty($this->input)){
            array_push($dynamicInput, ['attachment.*' => 'required|mimes:jpeg,png,jpg,gif,svg,xls,xlsx,doc,docx,pdf,shp|max:12240', 'filename.*' => 'required']);
        }
        foreach ($this->input as $key => $value) {
            array_push($dynamicInput, ['attachment.' . $value => 'required|mimes:jpeg,png,jpg,gif,svg,xls,xlsx,doc,docx,pdf,shp|max:12240', 'filename.' . $value => 'required']);
        }

        $mergeResult = call_user_func_array('array_merge', $dynamicInput);

        $staticInput = [
            'vehicle.vehicle_plate_no'                   => 'required|string',
            'vehicle.model'                   => 'required|string',
            'vehicle.make'                   => 'required|string',
            'vehicle.chassis_no'                   => 'required|string',
            'vehicle.engine_no'                   => 'required|string',
            'vehicle.OR_no'                   => 'required|string',
            'vehicle.CR_no'                   => 'required|string',
            'vehicle.color'                   => 'required|string',
            'vehicle.conduction_sticker'                   => 'required|string',
            'vehicle.year'             => 'required|integer',
            'vehicle.mode_of_acquisition'             => 'nullable|integer',
            'vehicle.supplier_origin'             => 'nullable|string',
            'vehicle.assigned_office'             => 'nullable|string',
            'vehicle.remarks'                         => 'string|nullable',
            'vehicle.status' => 'nullable|integer',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);

        // Inject authenticated user ID
        //$validate['user_id'] = auth()->id();

//        $this->validate();
        $this->vehicle->update();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->vehicle->id,
                'attachable_type' => 'App\Models\Vtt\Vehicle',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('trip_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }
        //Reset attachment upload
        $this->input = [];

        $this->alert('success', 'Vehicle Ticket', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully updated!',
        ]);

        $this->dispatchBrowserEvent('closeFormModal');

    }


    ////////////////////////////////////////////////////////////
    // Select Vehicle id to be deleted
    ////////////////////////////////////////////////////////////

    public function confirmDelete(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->emit('showDeleteConfirmation', ['detail' => $this->vehicle]);
    }

    ////////////////////////////////////////////////////////////
    // Delete PR by ID
    ////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!empty($this->vehicle->id)) {

            $this->alert('success', 'Vehicle Ticket', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'text' => $this->vehicle->id . ' - deleted successfully.',
            ]);

            $this->vehicle->delete();
            $this->vehicle = new Vehicle();
            $this->reset();
            $this->resetVariables();
            $this->emit('refreshParent');

        } else {

            $this->alert('error', 'Error!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'customClass' => [
                    'confirmButton' => "btn btn-primary",
                ],
                'text' => 'Error in deleting this record! ',
            ]);
        }
    }


    ////////////////////////////////////////////////////////////
    // Select the Attach Item ID to be deleted
    ////////////////////////////////////////////////////////////

    public function DeleteAttachment($id)
    {
        if (!empty($id)){

            $attachment = Attachment::where('id', $id)->where('attachable_type', 'App\Models\Vtt\Vehicle')->first();
            $this->deleteAttachment = $attachment;
            $this->confirm('Vehicle Ticket - attached document', [
                'text' => 'Are you sure do want to delete ' . $attachment->title . ' ?',
                'buttonsStyling' => false,
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonText' => 'Yes, Delete!',
                'cancelButtonText' => 'No, Cancel',
                'onConfirmed' => 'deleteAttachmentConfirmed',
                'customClass' => [
                    'confirmButton' => 'btn btn-danger btn-hover-scale',
                    'cancelButton' => 'btn btn-secondary btn-hover-scale',
                ]
            ]);

        }else{
            $this->alert('error', 'Error!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'customClass' => [
                    'confirmButton' => "btn btn-primary",
                ],
                'text' => 'Error in deleting this attachment! ',
            ]);
        }

    }


    ////////////////////////////////////////////////////////////
    // Delete Attached documents
    ////////////////////////////////////////////////////////////

    public function deleteAttachmentConfirmed(){
        if(!empty($this->deleteAttachment)){
            $attachment = $this->deleteAttachment;
            $title = $attachment->title;
            $attachable_id = $attachment->attachable_id;

            if(File::exists(public_path('storage/' . $attachment->filename))){
                File::delete(public_path('storage/' . $attachment->filename));
            }

            $attachment->delete();

            // Refresh attachment list
            $this->attachmentList = Attachment::where('attachable_id',$attachable_id )->where('attachable_type', 'App\Models\Vtt\Vehicle')->get();
            $this->deleteAttachment = '';

            $this->alert('success', 'Deleted!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'timerProgressBar' => true,
                'text' => 'Attachment - '.$title ?? '' .' has been successfully deleted.',
            ]);
        }else{
            $this->alert('error', 'Attachment Error', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
                'timerProgressBar' => true,
                'text' => 'Error in deleting the attachment.',
            ]);
        }
    }

    public function setstatus($id)
    {
        $vehicle = Vehicle::where('id', $id)->first();
        if(!empty($vehicle->status_date)){
            $this->emit('editstatus', ['id' => $id]);
        }else $this->emit('setstatus', ['id' => $id]);
    }

    public function updatestatus(Vehicle $vehicle){
        $this->vehicle = $vehicle;
        $this->vehicle->received_date = $vehicle->received_date ? Carbon::parse($vehicle->received_date)->format('Y-m-d') : '';
    }
}
