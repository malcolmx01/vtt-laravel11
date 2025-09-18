<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use App\Models\Vtt\Employee;
use App\Models\Vtt\Role;
use Session;

use DB;

use Auth;
use Image;
use App\Models\Vtt\Country;
use App\Models\Vtt\Region;
use App\Models\Vtt\Province;
use App\Models\Vtt\Citymun;
use App\Models\Vtt\Barangay;
use Carbon\Carbon;
use App\Models\Vtt\IdentificationCard;
use App\Models\Vtt\Nationality;

use Hash;
use Input;


use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }
        /*$employees = Employee::orderBy('id', 'desc')->get();*/
        return view('employees.index')
            ->with('store_id',$store_id);

            /*->withemployees($employees);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }
        /*        $roles = Role::all();
                return view('employees.create')->withRoles($roles);*/

        $roles = Role::all();
        return view('employees.create')
            ->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:employees',
            'password' => 'required|string|min:8|confirmed',
//            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = \Hash::make($request->password);

        if ($employee->save()) {

            if ($request->roles) {
                $employee->syncRoles(explode(',', $request->roles));
            }

            return redirect()->route('employees.show', $employee->id)
                ->with('flash', 'Your Account has been successfully created. You may activate it through your email.');
        } else {
            Session::flash('danger', 'Sorry a problem occurred while creating this user.');
            return redirect()->route('employees.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }
        $employee = Employee::where('id', $id)->first();
        return view("employees.show")
            ->with('employee',$employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $roles = Role::all();
        $employee = Employee::where('id', $id)->first();

        $companyProfile = DB::table('profiles')->get();
        $identification_cards = IdentificationCard::orderBy('id')->pluck('identification_card','id');
        $nationality_list = Nationality::orderBy('id')->pluck('nationality','id');

        $region = Region::orderBy('REGION')->get();
        $province = Province::orderBy('PROVINCE')->get();
        $cityMunicipality = DB::table('citymuns')
            ->join('provinces', 'provinces.PROVINCE_C', '=', 'citymuns.PROVINCE_C')
            ->select('citymuns.CITYMUN_C', 'citymuns.CITYMUN', 'citymuns.PROVINCE_C', 'citymuns.REGION_C', 'provinces.PROVINCE as PROVINCE')
            ->orderBy('citymuns.CITYMUN')
            ->orderBy('provinces.PROVINCE')
            ->get();

        $barangay = Barangay::orderBy('CITYMUN_C')->take(5)->get();

        $country = Country::orderBy('id')->pluck('country','id');


        return view("employees.edit")
            ->with('identification_cards',$identification_cards)
            ->with('nationality_list',$nationality_list)
            ->with('country', $country)
            ->with('regionList', $region)
            ->with('provinceList', $province)
            ->with('cityMunicipalityList', $cityMunicipality)
            ->with('barangayList', $barangay)
            ->withEmployee($employee)
            ->withRoles($roles)
            ->withCompanyProfile($companyProfile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $this->validateWith([
            'name' => 'required|min:3|max:150|regex:/^[a-zA-Z ]*$/',
            'username' => 'required|string|min:3|max:50|unique:employees,username,' . $id,
            'email' => 'required|string|email|min:6|max:50|unique:employees,email,' . $id
        ]);

        $employee = Employee::findOrFail($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->username = $request->username;
        $employee->status = $request->status;
        $employee->store_id = $request->store_id;
        $employee->class = $request->class;
        $employee->level = $request->level;
        $employee->contact_nos = $request->contact_nos;

        if (!empty($request->password)) {
            $employee->password = Hash::make($request->password);
        }

        if ($employee->save()) {
            if ($request->roles) {
                $employee->syncRoles(explode(',', $request->roles));
            }

            return redirect()->route('employees.show', $employee->id);
        } else {
            Session::flash('error', 'There was a problem saving the updated user info to the database. Try again later.');
            return redirect()->route('employees.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $employees = Employee::find($id);
        $employees->delete();
        return redirect('/employees')->with('success', 'Employee Removed');
    }

    /**
     * Show the list of employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function EmployeeList()
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        //$employees = Employee::all();

        $employees = DB::table('employees')
            ->join('profiles', 'employees.store_id', '=', 'profiles.id')
            ->select('employees.*', 'profiles.company')
            ->get();

        $rows = Employee::count();

        $meta = '{  
        "page": 1, 
        "pages": 1,
        "perpage": 10,     
        "total": ' . $rows . ',
        "sort": "asc",
        "field": "RecordID"
        }';

        $dataobject = json_decode($employees);
        $object = json_decode('{}');
        $object->meta = json_decode($meta);
        $object->data = $dataobject;

        return response()->json($object, 200, [], JSON_PRETTY_PRINT); // arranged properly
    }

    public function profiler()
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $region = Region::orderBy('REGION')->get();
        $province = Province::orderBy('PROVINCE')->get();
        $cityMunicipality = DB::table('citymuns')
            ->join('provinces', 'provinces.PROVINCE_C', '=', 'citymuns.PROVINCE_C')
            ->select('citymuns.CITYMUN_C', 'citymuns.CITYMUN', 'citymuns.PROVINCE_C', 'citymuns.REGION_C', 'provinces.PROVINCE as PROVINCE')
            ->orderBy('citymuns.CITYMUN')
            ->orderBy('provinces.PROVINCE')
            ->get();

        $barangay = Barangay::orderBy('CITYMUN_C')->take(5)->get();

        $companyProfile = DB::table('profiles')->get();

        return view('profile', array('user' => Auth::user()))
            ->with('regionList', $region)
            ->with('provinceList', $province)
            ->with('cityMunicipalityList', $cityMunicipality)
            ->with('barangayList', $barangay)
            ->with('companyProfile', $companyProfile);
    }

    public function update_avatar(Request $request)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }
        $employee = Auth::user();

        // Handle the user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('storage/uploads/avatars/' . $filename));

            $employee->avatar = $filename;
        }

        $this->validateWith([
            'name' => 'required|min:3|max:150|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|string|email|min:6|max:50|unique:employees,email,' . $employee->id,
            'username' => 'required|string|min:3|max:50|unique:employees,username,' . $employee->id,
            'first_name' => 'required|min:2|max:50|regex:/^[a-zA-Z ]*$/',
            /*'middle_name' => 'required|min:2|max:50|regex:/^[a-zA-Z ]*$/',*/
            'last_name' => 'required|min:2|max:50|regex:/^[a-zA-Z ]*$/'
        ]);

        if (!empty($request->password)) {
            $employee->password = Hash::make($request->password);
        }

        $barangay = DB::table('barangays')
            ->select('barangays.BARANGAY')
            ->where('barangays.BARANGAY_C', $request->input('userBarangay'))->pluck('BARANGAY')->first();

        $employee->name = $request->input('name');
        $employee->username = $request->input('username');
        $employee->email = $request->input('email');
        $employee->contact_nos = $request->contact_nos;

        $employee->first_name = $request->input('first_name');
        $employee->middle_name = $request->input('middle_name');
        $employee->last_name = $request->input('last_name');

        $employee->suffix = $request->input('suffix');

        $employee->first_name = $request->input('first_name');
        $employee->middle_name = $request->input('middle_name');
        $employee->last_name = $request->input('last_name');

        $employee->gender = $request->input('gender');
        $employee->civil_status = $request->input('civil_status');
        //$employee->birthday = $request->input('birthday');

        $employee->birthday = date("Y-m-d", strtotime(request('birthday')));

        $employee->REGION_C = $request->input('uRegion');
        $employee->PROVINCE_C = $request->input('uProvince');
        $employee->CITYMUN_C = $request->input('uCityMunicipality');
        $employee->BARANGAY_C = $request->input('userBarangay');
        $employee->BARANGAY = $barangay;
        $employee->address_details = $request->input('address_details');

        $employee->save();

        $region = Region::orderBy('REGION')->get();
        $province = Province::orderBy('PROVINCE')->get();

        $cityMunicipality = DB::table('citymuns')
            ->join('provinces', 'provinces.PROVINCE_C', '=', 'citymuns.PROVINCE_C')
            ->select('citymuns.CITYMUN_C', 'citymuns.CITYMUN', 'citymuns.PROVINCE_C', 'citymuns.REGION_C', 'provinces.PROVINCE as PROVINCE')
            ->orderBy('citymuns.CITYMUN')
            ->orderBy('provinces.PROVINCE')
            ->get();

        $barangay = Barangay::orderBy('CITYMUN_C')->take(5)->get();

        if ($employee->status <> 1) {
            auth()->logout();
            return redirect()->route('home')
                ->with('flash', 'Your Account has been successfully deactivated. You may reactivate by resetting your password.');
        }

        $companyProfile = DB::table('profiles')->get();

        return view('profile', array('user' => Auth::user()))
            ->with('regionList', $region)
            ->with('provinceList', $province)
            ->with('cityMunicipalityList', $cityMunicipality)
            ->with('barangayList', $barangay)
            ->with('companyProfile', $companyProfile);
    }

    public function update_password(Request $request)
    {

        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $employee = Auth::user();
        $store_id = auth()->user()->store_id;

        if (!empty($request->password)) {
            $employee->password = Hash::make($request->password);
        }

        $employee->password_changed_at = Carbon::now();
        $employee->save();

        return redirect()->guest(route('login'));
    }

    public function listProvince(Request $request)
    {

        if ($request->id == 0) {  // all provinces
            $data = Province::select('PROVINCE', 'PROVINCE_C')->all();
        } else {
            $data = Province::select('PROVINCE', 'PROVINCE_C')->where('REGION_C', $request->id)->get();
        }
        return response()->json($data);//then sent this data to ajax success
    }

    public function listCityMunicipality(Request $request)
    {

        $t = DB::table('provinces')
            ->join('citymuns', 'provinces.PROVINCE_C', '=', 'citymuns.PROVINCE_C')
            ->select('citymuns.CITYMUN_C', 'citymuns.CITYMUN', 'citymuns.PROVINCE_C', 'citymuns.REGION_C', 'provinces.PROVINCE as PROVINCE')->where('provinces.PROVINCE_C', $request->id)->get();

        return response()->json($t);//then sent this data to ajax success
    }

    public function setRegionProvince(Request $request)
    {

        $data = Citymun::select('REGION_C', 'PROVINCE_C')->where('CITYMUN_C', $request->id)->get();

        return response()->json($data);//then sent this data to ajax success
    }


    public function listBarangay(Request $request)
    {
        $data = DB::table('barangays')
            ->select('barangays.BARANGAY_C', 'barangays.BARANGAY', 'barangays.PROVINCE_C', 'barangays.REGION_C', 'citymuns.CITYMUN', "provinces.PROVINCE AS province")
            ->join('citymuns', function ($join) {
                $join->on('barangays.REGION_C', 'citymuns.REGION_C')
                    ->on('barangays.PROVINCE_C', 'citymuns.PROVINCE_C')
                    ->on('barangays.CITYMUN_C', 'citymuns.CITYMUN_C');
            })
            ->join('provinces', function ($join) {
                $join->on('barangays.REGION_C', 'provinces.REGION_C')
                    ->on('barangays.PROVINCE_C', 'provinces.PROVINCE_C');
            })
            ->where('citymuns.CITYMUN_C', $request->id)
            ->get();
    }

    public function employeesvalidator($id)
    {
        $statusDtl = DB::table('employees')
            ->select('employees.avatar', 'employees.name', 'employees.company', 'employees.status', 'employees.designation')
            ->where('employees.preview_id', $id)->get();

        return view('employees.employeevalidator')
            ->with('statusDtl', $statusDtl);
    }

    public function ddsv_employeesvalidator($id)
    {
        $statusDtl = DB::table('employees')
            ->select('employees.avatar', 'employees.name', 'employees.company', 'employees.status', 'employees.designation')
            ->where('employees.preview_id', $id)->get();

        return view('employees.ddsv_employeevalidator')
            ->with('statusDtl', $statusDtl);
    }

    public function responder_validator($id)
    {
        $statusDtl = DB::table('employees')
            ->select('employees.avatar', 'employees.company',  'employees.name', 'employees.status')
            ->where('employees.preview_id', $id)->get();

        return view('employees.responder_validator')
            ->with('statusDtl', $statusDtl);
    }

    public function resultsvalidator($id)
    {
        if (Auth::check()) {
            $user_class = auth()->user()->class;
        } else {
            $user_class = '0';
        }

        $resultsDtl = DB::table('lab_results')
            ->join('ecifs', 'lab_results.specimen_id', '=', 'ecifs.specimen_id')
            ->join('results', 'lab_results.results', '=', 'results.id')
            ->select('ecifs.avatar', 'ecifs.results_name', 'ecifs.suffix', 'ecifs.sex', 'ecifs.age', 'ecifs.birthday', 'ecifs.civil_status', 'ecifs.nationality', 'ecifs.permanent_phone_no', 'ecifs.permanent_cellphone_no', 'ecifs.email', 'ecifs.ID_presented', 'ecifs.ID_no', 'ecifs.address', 'ecifs.referring_institution_display', 'ecifs.specimen_id', 'ecifs.collection_method_display', 'ecifs.collection_datetime', 'results.results', 'results.result', 'lab_results.examination', 'lab_results.assay', 'lab_results.datetime_received', 'lab_results.released_date', 'lab_results.preview_id')
            ->where('lab_results.status', '11')
            ->when($user_class == '2', function ($q) {
                return $q->whereRaw('NOW() <= DATE_ADD(lab_results.released_date, INTERVAL 7 DAY)');
                //->whereRaw('NOW() >= lab_results.released_date');
            })
            ->where('lab_results.preview_id', $id)->get();

        $companyProfile = DB::table('profiles')
            ->where('profiles.id', '1' )->get();

        return view('pos.resultsvalidator')
            ->with('resultsDtl', $resultsDtl)
            ->with('companyProfile', $companyProfile);
    }

    public function antigenvalidator($id)
    {
        if (Auth::check()) {
            $user_class = auth()->user()->class;
        } else {
            $user_class = '0';
        }

        $resultsDtl = DB::table('antigen_results')
            ->join('eantigens', 'antigen_results.specimen_id', '=', 'eantigens.specimen_id')
            ->join('results', 'antigen_results.results', '=', 'results.id')
            ->select('eantigens.avatar', 'eantigens.show_picture_in_results', 'eantigens.name_and_type_of_test_kit',  'eantigens.results_name', 'eantigens.suffix', 'eantigens.gender', 'eantigens.age', 'eantigens.birthday', 'eantigens.civil_status', 'eantigens.nationality', 'eantigens.telno', 'eantigens.mobile_no', 'eantigens.email', 'eantigens.ID_presented', 'eantigens.ID_no', 'eantigens.address', 'eantigens.referring_institution_display', 'eantigens.specimen_id', 'eantigens.collection_method_display', 'eantigens.collection_datetime', 'results.results', 'antigen_results.examination', 'antigen_results.assay', 'antigen_results.datetime_received', 'antigen_results.released_date', 'antigen_results.preview_id')
            ->where('antigen_results.status', '11')
            ->when($user_class == '2', function ($q) {
                return $q->whereRaw('NOW() <= DATE_ADD(antigen_results.released_date, INTERVAL 7 DAY)');
            })
            ->where('antigen_results.preview_id', $id)->get();

        $companyProfile = DB::table('profiles')
            ->where('profiles.id', '1' )->get();

        return view('antigens.antigenvalidator')
            ->with('resultsDtl', $resultsDtl)
            ->with('companyProfile', $companyProfile);
    }
}
