@extends('layouts.ctrlpanel')
@section('content')

    <h1>Administration</h1>

    @role('superadministrator')
         <p>This is visible to users with the admin role.</p>
    @endrole

    @role('administrator')
        <p>This is visible to users with the admin role.</p>
    @endrole
@endsection