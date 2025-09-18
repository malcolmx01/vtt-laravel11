@extends('layouts.app')
@section('content')
@if(count($accounts) == 1)
<div class="container">
    <a href="/accounts" class="btn btn-default">Go Back</a> 
    <h1 >{{ $accounts->name }}</h1>
    <div>
        email: {{ $accounts->email }} 
    </div>
    <div>
        Account Status: {{ $accounts->status}} 
    </div>
    <br>
    <img style="width:20%; height:20%" src="/storage/account_image/{{$accounts->account_image}}">
    <hr>
    <small> Written on {{$accounts->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(in_array(Auth::user()->email , config('app.admin_emails')))
            <a href="/accounts/{{$accounts->id}}/edit" class="btn btn-default">Edit</a>
            {!!Form::open(['action'=>['AccountsController@destroy',$accounts->id], 'method'=>'account', 'class'=>'pull-right'])!!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif   
    @endif
@else
    <p>No account found</p>
@endif
</div>
@endsection