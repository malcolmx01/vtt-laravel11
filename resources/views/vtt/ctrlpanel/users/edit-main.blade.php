@extends('vtt.layouts.main')

@section('page','Users')
@section('description','Create New User')
@section('header-component')
    <a href="#" class="btn kt-subheader__btn-primary">
        Actions &nbsp;
        <i class="flaticon2-calendar-1"></i>
    </a>
    <a href="{{route('users.index')}}" class="btn btn-default btn-icon-sm">
        <i class="la la-list-ol"></i>
        User Archive
    </a>
@endsection

@section('content')
    <div class="container">
        <h1 >Edit Account</h1>
        {!! Form::open(['action' => ['UserController@update', $user->id],'method'  => 'account', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name','Name')}}
            {{Form::text('name',$user->name,['class'=>'form-control', 'placeholder'=>'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('email','email')}}
            {{Form::text('email',$user->email,['class'=>'form-control', 'placeholder'=>'email'])}}
        </div>

        <div class="form-group">
            {{Form::label('status','status')}}
            {{Form::text('status',$user->status,['class'=>'form-control', 'placeholder'=>'status'])}}
        </div>
        <img style="width:5%; height:5%" src="/storage/account_image/{{$user->account_image}}">
        <small>Account Image file: {{$user->account_image}}</small>
        <div class="form-group">
            {{Form::file('account_image')}}
            {{--  ,$accounts->account_image,['class'=>'form-control', 'placeholder'=>'account_image'])}}  --}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
