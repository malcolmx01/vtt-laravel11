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

//////////////////////////////
// Include Model
//////////////////////////////

use App\Models\Vtt\TopUp;
use App\Models\Vtt\Employee;
use App\Models\Vtt\Attachment;
use App\Models\Vtt\DocStatus;
use App\Models\Vtt\Vehicle;

//////////////////////////////
// Include Export
//////////////////////////////

use App\Exports\Pims\PRExport;
use App\Exports\Pims\PRPrintableExport;

class TopUps extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';


    //////////////////////////////
    // Model
    //////////////////////////////

//    public TopUp $prsheader;
    public $topup;
    public $addItemUniqid, $listOfDepartment, $listOfEmployee, $TopUpCollection, $disable = false;
    public $crud;
    public $DocStatus, $setstatusid, $VehiclePlateNo;
    public $disableeditdetails = false;

    public $itemSearch = '';
    public $itemSelected = [];
    public $itemCollection;
    public $seId, $sfId;

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
        SearchEmployee::EVENT_VALUE_UPDATED,
        'deleteAttachmentConfirmed',
        'updatestatus',
    ];

    protected $rules = [
        'topup.top_up_datetime'                 => 'required|date',
        'topup.top_up_liters'                   => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'topup.price_per_liter'             => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'topup.amount'                          => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'topup.odometer_reading'                 => 'required|integer',
        'topup.gas_station_and_address'                    => 'required|string',

        'topup.person_in_charge_id'             => 'required|integer',
        'topup.person_in_charge_name'           => 'nullable|string',
        'topup.person_in_charge_designation_id' => 'nullable|integer',
        'topup.person_in_charge_designation'    => 'nullable|string',
        'topup.person_in_charge_office_id'      => 'nullable|integer',
        'topup.person_in_charge_office'    => 'nullable|string',
        'topup.employee_no'                     => 'nullable|string',

        'topup.vehicle_plate_no'                   => 'required|string',

        'topup.remarks'                         => 'string|nullable',
        'topup.status' => 'nullable|integer',
        'topup.user_id'             => 'required|integer',
    ];

    protected $messages = [
        'topup.person_in_charge_id.required' => 'Person in Charge cannot be empty.',
        'topup.vehicle_plate_no.required' => 'Vehicle Plate No. cannot be empty.',
        'topup.odometer_reading.required' => 'Odometer Reading cannot be empty.',
        'topup.gas_station_and_address.required' => 'Gas Station name and address cannot be empty.',
        'topup.price_per_liter.required' => 'Price per liter cannot be empty.',
    ];

    public function mount()
    {
        $this->seId = Str::random();
        $this->sfId = Str::random();
        $this->TopUpCollection = TopUp::all();
        $this->DocStatus = DocStatus::all();
        $this->setstatusid = Str::random();
        $this->VehiclePlateNo = Vehicle::all();
    }

    public function updatingSearch() { $this->resetPage(); }


    public function search_employee_value_updated(Employee $employee){
        $this->topup->person_in_charge_id = $employee->id  ?? null;
        $this->topup->person_in_charge_name  = ($employee->first_name ?? null).' '.($employee->middle_name ?? null).' '.($employee->last_name ?? null);
        $this->topup->person_in_charge_designation_id = $employee->position_id ?? null;
        $this->topup->person_in_charge_designation = $employee->position ?? null;
        $this->topup->person_in_charge_office_id = $employee->office->id ?? null;
        $this->topup->person_in_charge_office = $employee->office->dept_name ?? null;
        $this->topup->employee_no = $employee->employee_no ?? null;
    }

    public function clear_employee(){
        $this->topup->person_in_charge_id = null;
        $this->topup->person_in_charge_name = null;
        $this->topup->person_in_charge_designation_id = null;
        $this->topup->person_in_charge_designation = null;
        $this->topup->person_in_charge_office_id = null;
        $this->topup->person_in_charge_office = null;
        $this->topup->employee_no = null;
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
        $defaultVariable = [
            'maximize',
            'showDetails',
            'disable',
            'crud',
        ];
        $this->reset($defaultVariable);
        $this->addItemUniqid = Str::random();
        $this->TopUpCollection = TopUp::all();
        $this->resetValidation();
    }

    public function render()
    {

        return view('livewire.vtt.topups.index', [
            'headers' => TopUp::search($this->search)
                ->with('docstatus')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ]);
    }


    ////////////////////////////////////////////////////////////
    // Open/Create TopUp Modal
    ////////////////////////////////////////////////////////////

    public function create()
    {
        $this->topup = new TopUp();
        $this->topup->status = 1;
        $this->crud = 'create';
        $this->topup->user_id = auth()->user()->id;
        $this->input = [];
        $this->attachmentList = [];
        $this->emit('resetAndLoadSelect2');
        $this->dispatchBrowserEvent('openFormModal');

    }

    ////////////////////////////////////////////////////////////
    // Save TopUp
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
            'topup.top_up_datetime'                 => 'required|date',
            'topup.top_up_liters'                   => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.price_per_liter'             => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.amount'                          => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.odometer_reading'                 => 'required|integer',
            'topup.gas_station_and_address'                    => 'required|string',

            'topup.person_in_charge_id'             => 'required|integer',
            'topup.person_in_charge_name'           => 'nullable|string',
            'topup.person_in_charge_designation_id' => 'nullable|integer',
            'topup.person_in_charge_designation'    => 'nullable|string',
            'topup.person_in_charge_office_id'      => 'nullable|integer',
            'topup.person_in_charge_office'    => 'nullable|string',
            'topup.employee_no'                     => 'nullable|string',

            'topup.vehicle_plate_no'                   => 'required|string',

            'topup.remarks'                         => 'string|nullable',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);
//        $this->validate();

        $this->topup->save();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->topup->id,
                'attachable_type' => 'App\Models\Vtt\TopUp',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('topup_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }
        //Reset attachment upload
        $this->input = [];

        $this->alert('success', 'Top Ups', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

//        $this->edit($this->topup);
        $this->dispatchBrowserEvent('closeFormModal');
    }

    ////////////////////////////////////////////////////////////
    // Showing TopUp Details
    ////////////////////////////////////////////////////////////

    public function show(TopUp $TopUp)
    {

        if ($TopUp->status > 1) {
            $this->disableeditdetails = true;
        }

        $this->topup = $TopUp;
        $this->topup->top_up_datetime = $TopUp->top_up_datetime ? Carbon::parse($TopUp->top_up_datetime)->format('Y-m-d h:i:s') : '';

        $this->topup->top_up_liters = $TopUp->top_up_liters ?? 0;
        $this->topup->price_per_liter = $TopUp->price_per_liter ?? 0;
        $this->topup->amount = $TopUp->amount ?? 0;
        $this->topup->odometer_reading = $TopUp->odometer_reading ?? 0;
        $this->topup->gas_station_and_address = $TopUp->gas_station_and_address ?? '';
        $this->topup->vehicle_plate_no = $TopUp->vehicle_plate_no ?? '';

        $this->topup->status = $this->topup->status ? $this->topup->status : 1; //Draft
        $this->attachmentList = Attachment::where('attachable_id',$TopUp->id)->where('attachable_type', 'App\Models\Vtt\TopUp')->get();
        $this->disable = true;
        $this->crud = 'show';
        $this->emit('loadDefaultValueAndDisable', [
            'person_in_charge_id' => $this->topup->person_in_charge_id ?? '',
            'remarks' => $this->topup->remarks ?? '',
        ]);
        $this->dispatchBrowserEvent('openFormModal');
    }

    ////////////////////////////////////////////////////////////
    // Edit TopUp Details
    ////////////////////////////////////////////////////////////

    public function edit(TopUp $TopUp)
    {
        $this->topup = $TopUp;
        $this->disable = false;
        $this->crud = 'edit';
        $this->topup->user_id = auth()->id();
        $this->topup->top_up_datetime = $TopUp->top_up_datetime ? Carbon::parse($TopUp->top_up_datetime)->format('Y-m-d h:i:s') : '';

        $this->topup->top_up_liters = $TopUp->top_up_liters ?? 0;
        $this->topup->price_per_liter = $TopUp->price_per_liter ?? 0;
        $this->topup->amount = $TopUp->amount ?? 0;
        $this->topup->odometer_reading = $TopUp->odometer_reading ?? 0;
        $this->topup->gas_station_and_address = $TopUp->gas_station_and_address ?? '';
        $this->topup->vehicle_plate_no = $TopUp->vehicle_plate_no ?? '';

        $this->topup->status = $this->topup->status ? $this->topup->status : 1; //Draft
        $this->attachmentList = Attachment::where('attachable_id',$TopUp->id)->where('attachable_type', 'App\Models\Vtt\TopUp')->get();
        $this->emit('loadDefaultValue', [
            'person_in_charge_id' => $this->topup->person_in_charge_id ?? '',
            'remarks' => $this->topup->remarks ?? '',
        ]);
        $this->dispatchBrowserEvent('openFormModal');
//        $this->dispatchBrowserEvent('scrollToBottom');

    }

    ////////////////////////////////////////////////////////////
    // Updated AreHeader Details
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
            'topup.top_up_datetime'                 => 'required|date',
            'topup.top_up_liters'                   => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.price_per_liter'             => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.amount'                          => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'topup.odometer_reading'                 => 'required|integer',
            'topup.gas_station_and_address'         => 'required|string',

            'topup.person_in_charge_id'             => 'required|integer',
            'topup.person_in_charge_name'           => 'nullable|string',
            'topup.person_in_charge_designation_id' => 'nullable|integer',
            'topup.person_in_charge_designation'    => 'nullable|string',
            'topup.person_in_charge_office_id'      => 'nullable|integer',
            'topup.person_in_charge_office'    => 'nullable|string',
            'topup.employee_no'                     => 'nullable|string',

            'topup.vehicle_plate_no'                   => 'required|string',

            'topup.remarks'                         => 'string|nullable',
        ];

        $validationRules = array_merge($staticInput, $mergeResult);
        $validate = $this->validate($validationRules);

//        $this->validate();
        $this->topup->update();

        // Save Uploaded Image
        foreach ($this->input as $key => $value) {
            Attachment::insert([
                'attachable_id' => $this->topup->id,
                'attachable_type' => 'App\Models\Vtt\TopUp',
                'title' => $this->filename[$value],
                'filename' => $this->attachment[$value]->store('topup_attachment', 'public'),
                'type' => strtolower($this->attachment[$value]->getClientOriginalExtension()),
            ]);
        }

        $this->input = [];

        $this->alert('success', 'Top Ups', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully updated!',
        ]);

        $this->dispatchBrowserEvent('closeFormModal');

    }

    ////////////////////////////////////////////////////////////
    // Search and Attach Item
    ////////////////////////////////////////////////////////////

//    public function searchSelectItem(Item $item)
    public function searchSelectItem($id)
    {
        $item = Item::where('id', $id)->first();
        $this->itemSearch = '';
        $this->emit('attachDetails', ['item_id' => $item->id, 'ris_header_id' => $this->topup->id]);

    }

    ////////////////////////////////////////////////////////////
    // Select TopUp id to be deleted
    ////////////////////////////////////////////////////////////

    public function confirmDelete(TopUp $TopUp)
    {
        $this->topup = $TopUp;
        $this->emit('showDeleteConfirmation', ['detail' => $this->topup]);
    }

    ////////////////////////////////////////////////////////////
    // Delete PR by ID
    ////////////////////////////////////////////////////////////

    public function delete()
    {
        if (!empty($this->topup->id)) {

            $this->alert('success', 'Top Ups', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'text' => $this->topup->id . ' - deleted successfully.',
            ]);

            $this->topup->delete();
            $this->topup = new TopUp();
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

            $attachment = Attachment::where('id', $id)->where('attachable_type', 'App\Models\Vtt\TopUp')->first();
            $this->deleteAttachment = $attachment;
            $this->confirm('Top Up - attached document', [
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
            $this->attachmentList = Attachment::where('attachable_id',$attachable_id )->where('attachable_type', 'App\Models\Vtt\TopUp')->get();
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
        $topup = TopUp::where('id', $id)->first();
        if(!empty($topup->status_date)){
            $this->emit('editstatus', ['id' => $id]);
        }else $this->emit('setstatus', ['id' => $id]);
    }

    public function updatestatus(TopUp $topup){
        $this->topup = $topup;
        $this->topup->received_date = $topup->received_date ? Carbon::parse($topup->received_date)->format('Y-m-d') : '';
    }
}
