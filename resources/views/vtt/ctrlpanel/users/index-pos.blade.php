@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Account</div>

                    <div class="form-group">
                        {!! Form::open(['method'=>'GET','action' => 'UsersController@index','class'=>'navbar-form navbar-left','role'=>'search'])  !!}
                            <a href="{{ url('/accounts/create') }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> Add</a>                
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" name="q" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default-sm" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>                            
                        {!! Form::close() !!}                                        
                    </div>
                
                <div class="panel-body">
                    <h3>Accounts</h3>

                    <div class="form-group">
                    
                        @if (count($accounts) > 0 )
                        <table class="table table-striped">
                            <tr>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('email','email')</th>
                                <th>@sortablelink('account_image','Image')</th>
                                <th>@sortablelink('status','Active')</th>
                            
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($accounts as $account)
                            <tr>
                                <td>{{$account->name}}</td>
                                <td>{{$account->email}}</td>
                                <td>
                                    <img style="margin:1px;width:50px;height:50px" src="/storage/account_image/{{$account->account_image}}">
                                </td>     
                                <td>{{$account->status}}</td>                                                                                                           
                                <td><a href="/accounts/{{$account->id}}/edit" class = "btn btn-default">Edit</a></td>
                                <td>
                                    {!!Form::open(['action'=>['AccountsController@destroy',$account->id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                                    {!!Form::close()!!}         
                                </td>                   
                            </tr>                    
                            @endforeach   
                            {{ $accounts->links()}}                                                                            
                        </table>    
                        @else
                            <p>No Account Available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
