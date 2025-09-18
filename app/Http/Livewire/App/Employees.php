<?php

namespace App\Http\Livewire\App;

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

//////////////////////////////
// Include Model
//////////////////////////////

use App\Models\Vtt\Employee;
use App\Models\Vtt\Department;
use App\Models\Vtt\Position;

class Employees extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    //////////////////////////////
    // Model
    //////////////////////////////

    public $employee;
    public $addItemUniqid, $listOfDepartment, $listOfPosition, $listOfEmployee, $EmployeeCollection, $disable = false;
    public $crud, $seId;

    public $input = [];
    public $i = 1;
    public $attachment, $filename, $deleteAttachment, $attachmentList = [];
    public $signature, $avatar;

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
        'ArchiveEmployeeRecord' => 'archive',
        'CreateNewEmployeeRecord' => 'create',
        'refreshEmployeeParent' => '$refresh',
        'deleteEmployeeAvatarConfirmed' => 'deleteAvatarConfirmed',
        'deleteEmployeeSignatureConfirmed' => 'deleteSignatureConfirmed',
    ];

    protected $rules = [

        'employee.employee_no'     => 'nullable|string',
        'employee.first_name'      => 'required|string',
        'employee.middle_name'     => 'nullable|string',
        'employee.last_name'       => 'required|string',

        'employee.birthday'        => 'required|date',
        'employee.sex'             => 'nullable|integer',
        'employee.email'           => 'nullable|email',
        'employee.mobile_nos'      => 'nullable|string',
        'employee.tel_nos'         => 'nullable|string',

        'employee.department_id'   => 'nullable|integer',
        'employee.department'      => 'nullable|string',
        'employee.dept_code'       => 'nullable|string',

        'employee.position_id'     => 'nullable|integer',
        'employee.position'        => 'nullable|string',
        'employee.position_code'   => 'nullable|string',

        'employee.avatar'          => 'nullable|string',
        'employee.signature'       => 'nullable|string',

        'avatar'          => 'nullable|mimes:jpeg,png,jpg,gif|max:12240',
        'signature'       => 'nullable|mimes:jpeg,png,jpg,gif|max:12240',

    ];

    protected $messages = [
//        'employee.transaction_datetime.required' => 'Transaction Date and time  cannot be empty.',
//        'employee.starting_ODO.required' => 'Starting ODO cannot be empty.',
    ];

    public function mount()
    {
        $this->seId = Str::random();
        $this->addItemUniqid = Str::random();
        $this->listOfDepartment = Department::all();
        $this->listOfPosition = Position::all();
    }

    public function updatingSearch() { $this->resetPage(); }


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
            'avatar',
            'signature',
        ];
        $this->reset($defaultVariable);
        $this->addItemUniqid = Str::random();
        $this->listOfDepartment = Department::all();
        $this->listOfPosition = Position::all();
        $this->resetValidation();
    }

    public function updatedEmployeeDepartmentId($id)
    {
        $department = Department::where('id', $id)->first();
        if(!empty($department)){
            $this->employee->department_id = $department->id;
            $this->employee->department = (string)$department->dept_name;
            $this->employee->dept_code = (string)$department->dept_code;
        }
    }

    public function updatedEmployeePositionId($id)
    {
        $position = Position::where('id', $id)->first();
        if(!empty($position)){
            $this->employee->position_id = $position->id;
            $this->employee->position = (string)$position->pos_name;
            $this->employee->position_code = (string)$position->pos_code;
        }
    }

    public function render()
    {
        return view('livewire.app.employees.index', [
            'employees' => Employee::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }

    ////////////////////////////////////////////////////////////
    // Archive Employee Modal
    ////////////////////////////////////////////////////////////

    public function archive()
    {
        $this->dispatchBrowserEvent('openEmployeeArchiveModal');
    }


    ////////////////////////////////////////////////////////////
    // Open/Create Employee Modal
    ////////////////////////////////////////////////////////////

    public function create()
    {
        $this->employee = new Employee();
        $this->crud = 'create';
        $this->input = [];
        $this->emit('EmployeeResetAndLoadSelect2');
        $this->dispatchBrowserEvent('openFormEmployeeModal');

    }

    ////////////////////////////////////////////////////////////
    // Save Employee
    ////////////////////////////////////////////////////////////

    public function store()
    {

//        dd(gettype($this->employee->dept_code));

//        $department = Department::where('id', $this->employee->department_id)->first();
//        $position = Position::where('id', $this->employee->position_id)->first();

//        $department = Department::where('id', $this->employee->department_id)->first();
//        $this->employee->department_id = $department->id ?? null;
//        $this->employee->department = $department->dept_name ?? null;
//        $this->employee->dept_code = $department->dept_code ?? null;
//
//        $position = Position::where('id', $this->employee->position_id)->first();
//        $this->employee->position_id = $position->id ?? null;
//        $this->employee->position = $position->pos_name ?? null;
//        $this->employee->position_code = $position->pos_code ?? null;

        if (empty($this->employee->position_id)){
            $this->employee->position_id = null;
            $this->employee->position = null;
            $this->employee->position_code = null;
        }

        if (empty($this->employee->department_id)){
            $this->employee->department_id = null;
            $this->employee->department = null;
            $this->employee->dept_code = null;
        }

        if (!empty($this->avatar)){
            $avatar = $this->avatar->store('avatar', 'public');
        }else{
            $avatar = '';
        }

        if (!empty($this->signature)){
            $signature = $this->signature->store('signature', 'public');
        }else{
            $signature = '';
        }

        $this->employee->avatar = $avatar;
        $this->employee->signature = $signature;

        $this->avatar = null;
        $this->signature = null;

        $this->validate();
        $this->employee->save();

        $this->resetVariables();

        $this->alert('success', 'Employee', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully saved!',
        ]);

        $this->dispatchBrowserEvent('closeFormEmployeeModal');
    }

    ////////////////////////////////////////////////////////////
    // Showing Employee Details
    ////////////////////////////////////////////////////////////

    public function show(Employee $employee)
    {
        $this->employee = $employee;
        $this->employee->birthday = $employee->birthday ? Carbon::parse($employee->birthday)->format('Y-m-d') : '';

        $this->disable = true;
        $this->crud = 'show';

        $this->emit('EmployeeLoadDefaultValueAndDisable', [
            'department_id' => $this->employee->department_id,
            'position_id' => $this->employee->position_id,
        ]);
        $this->dispatchBrowserEvent('openFormEmployeeModal');
//        $this->dispatchBrowserEvent('scrollToBottom');
    }

    ////////////////////////////////////////////////////////////
    // Edit Employee Details
    ////////////////////////////////////////////////////////////

    public function edit(Employee $employee)
    {
        $this->employee = $employee;
        $this->disable = false;
        $this->crud = 'edit';
        $this->employee->birthday = $employee->birthday ? Carbon::parse($employee->birthday)->format('Y-m-d') : '';

        $this->emit('EmployeeLoadDefaultValue', [
            'department_id' => $this->employee->department_id,
            'position_id' => $this->employee->position_id,
        ]);
        $this->dispatchBrowserEvent('openFormEmployeeModal');
//        $this->dispatchBrowserEvent('scrollToBottom');

    }

    ////////////////////////////////////////////////////////////
    // Updated Employee Details
    ////////////////////////////////////////////////////////////

    public function update()
    {

        if (empty($this->employee->position_id)){
            $this->employee->position_id = null;
            $this->employee->position = null;
            $this->employee->position_code = null;
        }

        if (empty($this->employee->department_id)){
            $this->employee->department_id = null;
            $this->employee->department = null;
            $this->employee->dept_code = null;
        }

        if (!empty($this->avatar)){
            $avatar = $this->avatar->store('avatar', 'public');
            $this->employee->avatar = $avatar;
        }

        if (!empty($this->signature)){
            $signature = $this->signature->store('signature', 'public');
            $this->employee->signature = $signature;
        }

        $this->avatar = null;
        $this->signature = null;

        $this->validate();
        $this->employee->update();

        $this->resetVariables();

        $this->alert('success', 'Employee', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'text' => 'Record successfully updated!',
        ]);

        $this->dispatchBrowserEvent('closeFormEmployeeModal');

    }


    ////////////////////////////////////////////////////////////
    // Select Employee id to be deleted
    ////////////////////////////////////////////////////////////

    public function confirmDelete(Employee $employee)
    {
        $this->employee = $employee;
        $this->emit('showDeleteConfirmation', ['detail' => $this->employee]);
    }

    public function delete()
    {
        if (!empty($this->employee->id)) {

            $this->alert('success', 'Employee Ticket', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'text' => $this->employee->id . ' - deleted successfully.',
            ]);

            $this->employee->delete();
            $this->employee = new Employee();
            $this->reset();
            $this->resetVariables();
            $this->emit('refreshEmployeeParent');

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
    // Deleted Avatar and Signature
    ////////////////////////////////////////////////////////////

    public function DeleteAvatar($id){

        $this->confirm('Employee Avatar', [
            'text' => 'Are you sure you want to delete this avatar?',
            'buttonsStyling' => false,
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Delete!',
            'cancelButtonText' => 'No, Cancel',
            'onConfirmed' => 'deleteEmployeeAvatarConfirmed',
            'customClass' => [
                'confirmButton' => 'btn btn-danger btn-hover-scale',
                'cancelButton' => 'btn btn-secondary btn-hover-scale',
            ]
        ]);

    }

    public function deleteAvatarConfirmed(){

        if (empty($this->employee->position_id)){
            $this->employee->position_id = null;
            $this->employee->position = null;
            $this->employee->position_code = null;
        }

        if (empty($this->employee->department_id)){
            $this->employee->department_id = null;
            $this->employee->department = null;
            $this->employee->dept_code = null;
        }

        if(File::exists(public_path('storage/' .  $this->employee->avatar))){
            File::delete(public_path('storage/' .  $this->employee->avatar));
        }

        $this->employee->avatar = null;
        $this->employee->update();

        $this->alert('success', 'Deleted!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => false,
            'timerProgressBar' => true,
            'text' => 'Employee avatar has been successfully deleted.',
        ]);

    }


    public function DeleteSignature($id){

        $this->confirm('Employee Signature', [
            'text' => 'Are you sure you want to delete this signature?',
            'buttonsStyling' => false,
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Delete!',
            'cancelButtonText' => 'No, Cancel',
            'onConfirmed' => 'deleteEmployeeSignatureConfirmed',
            'customClass' => [
                'confirmButton' => 'btn btn-danger btn-hover-scale',
                'cancelButton' => 'btn btn-secondary btn-hover-scale',
            ]
        ]);

    }

    public function deleteSignatureConfirmed(){

        if (empty($this->employee->position_id)){
            $this->employee->position_id = null;
            $this->employee->position = null;
            $this->employee->position_code = null;
        }

        if (empty($this->employee->department_id)){
            $this->employee->department_id = null;
            $this->employee->department = null;
            $this->employee->dept_code = null;
        }

        if(File::exists(public_path('storage/' .  $this->employee->signature))){
            File::delete(public_path('storage/' .  $this->employee->signature));
        }

        $this->employee->signature = null;
        $this->employee->update();

        $this->alert('success', 'Deleted!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => false,
            'timerProgressBar' => true,
            'text' => 'Employee signature has been successfully deleted.',
        ]);

    }




}
