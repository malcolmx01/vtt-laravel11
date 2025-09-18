@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 >Edit Account</h1>
        {!! Form::open(['action' => ['AccountsController@update', $accounts->id],'method'  => 'account', 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name',$accounts->name,['class'=>'form-control', 'placeholder'=>'name'])}}
            </div>
            <div class="form-group">
                {{Form::label('email','email')}}
                {{Form::text('email',$accounts->email,['class'=>'form-control', 'placeholder'=>'email'])}}
            </div>   
            <div class="form-group">
                {{Form::label('status','Status')}}
                {{ Form::select('status', array(1 => 'Active', 0 => 'Inactive'), $accounts->status ) }}
            </div>   
            <img style="width:5%; height:5%" src="/storage/account_image/{{$accounts->account_image}}">
            <small>Account Image file: {{$accounts->account_image}}</small>
            <div class="form-group">
                {{Form::file('account_image')}}
                {{--  ,$accounts->account_image,['class'=>'form-control', 'placeholder'=>'account_image'])}}  --}}
            </div>         
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection