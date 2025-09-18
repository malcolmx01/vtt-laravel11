<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use App\Models\Vtt\Export;
use Illuminate\Http\Request;

class ExportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function show(Export $export)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function edit(Export $export)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Export $export)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy(Export $export)
    {
        //
    }
}
