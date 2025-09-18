<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Illuminate\Validation\Rule;
use DB;
use Exception;
use File;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Vtt\Department;
use App\Models\Vtt\Employee;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';


    //////////////////////////////
    // Model
    //////////////////////////////

    public $code, $access_role, $group, $group_id;
    public $rating, $store_id, $status, $user_id, $show_id;
    public $createTempImage, $tempImage;

    //////////////////////////////
    // Data Collection Container
    //////////////////////////////

    public $listOfUsers, $listOfDepartment, $listOfEmployee;


    public function mount()
    {
        $this->listOfDepartment = Department::all();
        $this->listOfEmployee = Employee::all();
    }

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

    public $isModalOpen = 0;
    public $crud = false;
    public $selected_id, $deleteId, $deletedRow, $showid;
    public $showDetails, $editDetails, $email, $avatar, $approved;


    protected function rules(){
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'approved' => 'required',
            'status' => 'required',
            'type' => 'required',
            'class' => 'required',
            'level' => 'required',
        ];
    }



    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.users.index', [
            'users' => User::search($this->search)
                ->with('info')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }

    public function resetInput(){
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->approved = '0';
        $this->status = '1';
        $this->type = '1';
        $this->class = '0';
        $this->level = '0';
    }

    public function create(){
        $this->resetInput();
        if($this->crud == 'create') $this->crud = '';
        else{
            $this->crud = 'create';
        }
    }

    public function store(){

        $this->validate();
        try {
            DB::beginTransaction();

            if ( empty($this->store_id)  ) { $this->store_id = 1; }

            $user = User::Create([
                'first_name'    => $this->first_name,
                'last_name'     => $this->last_name,
                'email'         => $this->email,
                'password'      => $this->password,
                'approved'      => $this->approved,
                'status'        => 1,
                'type'          => $this->type,
                'class'         => $this->class,
                'level'         => $this->level,
            ]);

            DB::commit();

        } catch (Exception $e) {
            dd($e);
            DB::rollBack();

            session()->flash('error', 'Error in saving User!'.$e->getMessage());
            $this->dispatchBrowserEvent('userStore');

            return $e->getMessage();
        }


        $this->crud = '';
        $this->resetInput();
        session()->flash('message', 'New User created successfully.');

        $this->emit('userStore');
        $this->emit('goToTopPage');
    }

    public function show(User $user)
    {
        $info = $user->info;

        $this->showDetails  = true;
        if($user){
            $this->first_name       = $user->first_name;
            $this->last_name        = $user->last_name;
            $this->email            = $user->email;
            $this->password         = $user->password;
            $this->approved         = $user->approved;
            $this->status           = $user->status;
            $this->type             = $user->type;
            $this->class            = $user->class;
            $this->level            = $user->level;

            $this->show_id          = $user->id;

            if($info){
                $this->avatar = $info->avatar;
                $this->company = $info->company;
                $this->office_id = $info->office_id;
                $this->employee_id = $info->employee_id;
                $this->office = $info->office;
                $this->phone = $info->phone;
            } else {
                $this->avatar           = "";
                $this->company          = "";
                $this->office_id           = "";
                $this->employee_id           = "";
                $this->office           = "";
                $this->phone            = "";
            }
        }else{
            $this->showDetails  = false;
        }
    }

    public function showToggle(){
        if($this->showDetails) $this->showDetails = false;
        else $this->showDetails = true;
    }

    public function closeShow(){
        $this->showDetails  = false;
    }

    public function edit(User $user)
    {
        if($user){

            $info = $user->info;

            $this->editDetails  = true;
            $this->selected_id  = $user->id;

            $this->first_name       = $user->first_name;
            $this->last_name        = $user->last_name;
            $this->email            = $user->email;
            $this->password         = $user->password;
            $this->approved         = $user->approved;
            $this->status           = $user->status;
            $this->type             = $user->type;
            $this->class            = $user->class;
            $this->level            = $user->level;

            $this->show_id          = $user->id;

            if($info){
                $this->avatar = $info->avatar;
                $this->company = $info->company;
                $this->office_id = $info->office_id;
                $this->employee_id = $info->employee_id;

                $this->office = $info->office;
                $this->phone = $info->phone;
            } else {
                $this->avatar = "";
                $this->company = "";
                $this->office_id = "";
                $this->employee_id = "";

                $this->office = "";
                $this->phone = "";
            }

            $this->emit('showDefaultValue', ['employee_id' => $info->employee_id ?? '', 'office_id' => $info->office_id ?? '']);

        }else{
            $this->editDetails  = false;
        }
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'approved' => 'required',
            'status' => 'required',
            'type' => 'required',
            'class' => 'required',
            'level' => 'required',
        ]);

        if($this->createTempImage) {

            if(!empty($this->category_image)){
                if(File::exists(public_path('storage/' . $this->category_image))){
                    File::delete(public_path('storage/' . $this->category_image));
                }
            }

            $this->createTempImage->store('category_image', 'public');
        }

        try {
            DB::beginTransaction();

            $user = User::findOrFail($this->selected_id)->update([
                'first_name'    => $this->first_name,
                'last_name'     => $this->last_name,
                'email'         => $this->email,
                'password'      => $this->password,
                'approved'      => $this->approved,
                'status'        => 1,
                'type'          => $this->type,
                'class'         => $this->class,
                'level'         => $this->level,
            ]);


            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            session()->flash('error', 'Error in saving User!'.$e->getMessage());
            $this->dispatchBrowserEvent('userUpdate');

            return $e->getMessage();
        }

        $this->resetInput();
        session()->flash('message', 'User updated successfully.');
        $this->emit('userUpdate');
        $this->emit('goToTopPage');

    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->deletedRow = User::where('id', $this->deleteId)->first();
    }

    public function delete()
    {
        $User = User::where('id', $this->deleteId)->first();
        if(!empty($User->id)) {

            session()->flash('message', $User->first_name.' '.$User->last_name .' - User deleted successfully.');

            User::where('id', $this->deleteId)->delete();

            $this->mount();
            $this->render();
            $this->emit('goToTopPage');
        }else{
            session()->flash('error', 'Error deleting User!');
        }

    }

    public function downloadExcel()
    {
        return (new UsersExport($this->search))->download('users.xlsx');
    }

    public function deleteRecords(){
        dd('delete');
    }

    public function exportSelected(){
        dd('export');
    }

}
