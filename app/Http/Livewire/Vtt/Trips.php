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

use App\Models\Vtt\Trip;
use App\Models\Vtt\Department;
use App\Models\Vtt\Employee;
use App\Models\Vtt\Item;
use App\Models\Vtt\Attachment;
use App\Models\Vtt\DocStatus;
use App\Models\Vtt\Vehicle;

//////////////////////////////
// Include Export
//////////////////////////////

//use App\Exports\Pims\PRExport;
//use App\Exports\Pims\PRPrintableExport;

class Trips extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';


    //////////////////////////////
    // Model
    //////////////////////////////

    public $trip;
    public $addItemUniqid, $listOfDepartment, $listOfEmployee, $TripCollection, $disable = false;
    public $crud;
    public $DocStatus, $setstatusid, $VehiclePlateNo;
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

        'trip.transaction_datetime'     => 'required|date',

        'trip.origin'                   => 'required|string',
        'trip.departure'                => 'required|date',
        'trip.starting_ODO'             => 'required|integer',

        'trip.destination'              => 'required|string',
        'trip.arrival'                  => 'required|date',
        'trip.ending_ODO'               => 'nullable|integer',

        'trip.total_mileage'            => 'nullable|integer',

        'trip.round_trip'                => 'nullable|integer',

        'trip.purpose_trip_details'     => 'nullable|string',
        'trip.authorized_passengers'    => 'nullable|string',
        'trip.visited_places'           => 'nullable|string',
        'trip.vehicle_plate_no'         => 'nullable|string',
        'trip.status' => 'nullable|integer',

        'trip.person_in_charge_id'             => 'required|integer',
        'trip.person_in_charge_name'           => 'nullable|string',
        'trip.person_in_charge_designation_id' => 'nullable|integer',
        'trip.person_in_charge_designation'    => 'nullable|string',
        'trip.person_in_charge_office_id'      => 'nullable|integer',
        'trip.person_in_charge_office'    => 'nullable|string',
        'trip.employee_no'                     => 'nullable|string',

        'trip.vehicle_plate_no'                   => 'required|string',
        'trip.user_id'             => 'required|integer',

    ];

    protected $messages = [
        'trip.person_in_charge_id.required' => 'Person in Charge cannot be empty.',
        'trip.vehicle_plate_no.required' => 'Vehicle Plate No. cannot be empty.',
        'trip.odometer_reading.required' => 'Odometer reading cannot be empty.',
        'trip.origin.required' => 'Origin cannot be empty.',
        'trip.destination.required' => 'Destination cannot be empty.',
        'trip.departure.required' => 'Departure date cannot be empty.',
    ];

    public function mount()
    {
        $this->seId = Str::random();
        $this->addItemUniqid = Str::random();
        $this->listOfDepartment = Department::all();
        $this->TripCollection = Trip::all();
        $this->DocStatus = DocStatus::all();
        $this->setstatusid = Str::random();
        $this->VehiclePlateNo = Vehicle::all();
    }

    public function updatingSearch() { $this->resetPage(); }

    public function search_employee_value_updated(Employee $employee){
        $this->trip->person_in_charge_id = $employee->id  ?? null;
        $this->trip->person_in_charge_name  = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->trip->person_in_charge_designation_id = $employee->position_id ?? null;
        $this->trip->person_in_charge_designation = $employee->position ?? null;
        $this->trip->person_in_charge_office_id = $employee->office->id ?? null;
        $this->trip->person_in_charge_office = $employee->office->dept_name ?? null;
        $this->trip->employee_no = $employee->employee_no ?? null;
    }

    public function clear_employee(){
        $this->trip->person_in_charge_id = null;
        $this->trip->person_in_charge_name = null;
        $this->trip->person_in_charge_designation_id = null;
        $this->trip->person_in_charge_designation = null;
        $this->trip->person_in_charge_office_id = null;
        $this->trip->person_in_charge_office = null;
        $this->trip->employee_no = null;
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
        $this->listOfDepartment = Department::all();
        $this->TripCollection = Trip::all();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.vtt.trips.index', [
            'trips' => Trip::search($this->search)
                ->with('docstatus')
//                ->withCount('RisDetail', 'SaiDetail')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }


    ////////////////////////////////////////////////////////////
    // Open/Create Trip Modal
    ////////////////////////////////////////////////////////////

    public function create()
    {
        $this->trip = new Trip();
        $this->trip->status = 1;
        $this->trip->user_id = auth()->user()->id;
        $this->crud = 'create';
        $this->input = [];
        $this->attachmentList = [];
        $this->emit('resetAndLoadSelect2');
        $this->dispatchBrowserEvent('openFormModal');

    }

    ////////////////////////////////////////////////////////////
    // Save Trip
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
            'trip.transaction_datetime'     => 'required|date',

            'trip.origin'                   => 'required|string',
            'trip.departure'                => 'required|date',
            'trip.starting_ODO'             => 'required|integer',

            'trip.destination'              => 'required|string',
            'trip.arrival'                  => 'required|date',
            'trip.ending_ODO'               => 'nullable|integer',

            'trip.total_mileage'            => 'nullable|integer',

            'trip.purpose_trip_details'     => 'nullable|string',
            'trip.authorized_passengers'    => 'nullable|string',
            'trip.visited_places'           => 'nullable|string',
            'trip.vehicle_plate_no'         => 'nullable|string',
//        'trip.remarks'                  => 'nullable|string',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);

//        $this->validate();
        $this->trip->save();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->trip->id,
                'attachable_type' => 'App\Models\Vtt\Trip',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('trip_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }
        //Reset attachment upload
        $this->input = [];

        $this->alert('success', 'Trip Ticket', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->dispatchBrowserEvent('closeFormModal');
    }

    ////////////////////////////////////////////////////////////
    // Showing Trip Details
    ////////////////////////////////////////////////////////////

    public function show(Trip $trip)
    {

        if ($trip->status > 1) {
            $this->disableeditdetails = true;
        }

        $this->trip = $trip;
        $this->trip->departure = $trip->departure ? Carbon::parse($trip->departure)->format('Y-m-d h:i:s') : '';
        $this->trip->arrival = $trip->arrival ? Carbon::parse($trip->arrival)->format('Y-m-d h:i:s') : '';
        $this->trip->transaction_datetime = $trip->transaction_datetime ? Carbon::parse($trip->transaction_datetime)->format('Y-m-d h:i:s') : '';
        $this->trip->status = $this->trip->status ? $this->trip->status : 1; //Draft
        $this->attachmentList = Attachment::where('attachable_id',$trip->id)->where('attachable_type', 'App\Models\Vtt\Trip')->get();
        $this->disable = true;
        $this->crud = 'show';
        $this->emit('loadDefaultValueAndDisable', [
            'purpose_trip_details' => $this->trip->purpose_trip_details ?? '',
            'authorized_passengers' => $this->trip->authorized_passengers ?? '',
            'person_in_charge_id' => $this->trip->person_in_charge_id ?? '',
            'remarks' => $this->trip->remarks ?? '',
        ]);

        $this->dispatchBrowserEvent('openFormModal');
//        $this->dispatchBrowserEvent('scrollToBottom');
    }

    ////////////////////////////////////////////////////////////
    // Edit Trip Details
    ////////////////////////////////////////////////////////////

    public function edit(Trip $trip)
    {
        $this->trip = $trip;
        $this->disable = false;
        $this->crud = 'edit';
        $this->trip->user_id = auth()->id();

        $this->trip->departure = $trip->departure ? Carbon::parse($trip->departure)->format('Y-m-d h:i:s') : '';
        $this->trip->arrival = $trip->arrival ? Carbon::parse($trip->arrival)->format('Y-m-d h:i:s') : '';
        $this->trip->transaction_datetime = $trip->transaction_datetime ? Carbon::parse($trip->transaction_datetime)->format('Y-m-d h:i:s') : '';
        $this->trip->status = $this->trip->status ? $this->trip->status : 1; //Draft
        $this->attachmentList = Attachment::where('attachable_id',$trip->id)->where('attachable_type', 'App\Models\Vtt\Trip')->get();

        $this->emit('loadDefaultValue', [
            'purpose_trip_details' => $this->trip->purpose_trip_details ?? '',
            'authorized_passengers' => $this->trip->authorized_passengers ?? '',
            'person_in_charge_id' => $this->trip->person_in_charge_id ?? '',
            'remarks' => $this->trip->remarks ?? '',
        ]);
        $this->dispatchBrowserEvent('openFormModal');
//        $this->dispatchBrowserEvent('scrollToBottom');

    }

    ////////////////////////////////////////////////////////////
    // Updated Trip Details
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
            'trip.transaction_datetime'     => 'required|date',

            'trip.origin'                   => 'required|string',
            'trip.departure'                => 'required|date',
            'trip.starting_ODO'             => 'required|integer',

            'trip.destination'              => 'required|string',
            'trip.arrival'                  => 'required|date',
            'trip.ending_ODO'               => 'nullable|integer',

            'trip.total_mileage'            => 'nullable|integer',

            'trip.purpose_trip_details'     => 'nullable|string',
            'trip.authorized_passengers'    => 'nullable|string',
            'trip.visited_places'           => 'nullable|string',
            'trip.vehicle_plate_no'         => 'nullable|string',
//        'trip.remarks'                  => 'nullable|string',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);

//        $this->validate();
        $this->trip->update();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->trip->id,
                'attachable_type' => 'App\Models\Vtt\Trip',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('trip_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }
        //Reset attachment upload
        $this->input = [];

        $this->alert('success', 'Trip Ticket', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully updated!',
        ]);

        $this->dispatchBrowserEvent('closeFormModal');

    }


    ////////////////////////////////////////////////////////////
    // Select Trip id to be deleted
    ////////////////////////////////////////////////////////////

    public function confirmDelete(Trip $trip)
    {
        $this->trip = $trip;
        $this->emit('showDeleteConfirmation', ['detail' => $this->trip]);
    }

    ////////////////////////////////////////////////////////////
    // Delete PR by ID
    ////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!empty($this->trip->id)) {

            $this->alert('success', 'Trip Ticket', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'text' => $this->trip->id . ' - deleted successfully.',
            ]);

            $this->trip->delete();
            $this->trip = new Trip();
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

            $attachment = Attachment::where('id', $id)->where('attachable_type', 'App\Models\Vtt\Trip')->first();
            $this->deleteAttachment = $attachment;
            $this->confirm('Trip Ticket - attached document', [
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
            $this->attachmentList = Attachment::where('attachable_id',$attachable_id )->where('attachable_type', 'App\Models\Vtt\Trip')->get();
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
        $trip = Trip::where('id', $id)->first();
        if(!empty($trip->status_date)){
            $this->emit('editstatus', ['id' => $id]);
        }else $this->emit('setstatus', ['id' => $id]);
    }

    public function updatestatus(Trip $trip){
        $this->trip = $trip;
        $this->trip->received_date = $trip->received_date ? Carbon::parse($trip->received_date)->format('Y-m-d') : '';
    }
}
