<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Vtt\Employee;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $employees = Employee::
            with('position:pos_name', 'office:dept_name')
            ->where('last_name', 'like', '%'.$request->input('term', '').'%')
            ->orWhere('first_name', 'like', '%'.$request->input('term', '').'%')
//            ->where('name', 'LIKE', '%'.$request->input('term', '').'%')
            ->get(['id', 'first_name as text']);
        return ['employees' => $employees];
    }
}
