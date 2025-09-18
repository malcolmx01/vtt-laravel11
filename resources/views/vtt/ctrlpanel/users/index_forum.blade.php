@extends('layouts.ctrlpanel')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-users2"></span> Manage Users</li>
                </ol>
            </nav>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-users2"></span> Users
                    </h3>
                </div>

                <div class="form-group">

                    @include('layouts.search',['url'=>'user','link'=>'ctrlpanel/users'])

                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr class="bg-light">
                                <th>@sortablelink('username','UserName')</th>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('email','Email')</th>
                                <th>@sortablelink('status','Status')</th>
                                <th>@sortablelink('dpo','DPO')</th>
                                <th>@sortablelink('channel_id','Affiliation')</th>
                                <th>@sortablelink('created_at','Date Registered')</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>{{$user->username}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>

                                        <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" disabled >
                                            <option value="0" @if($user->status == 0) selected @endif >For Activation</option>
                                            <option value="1" @if($user->status == 1) selected @endif >Active</option>
                                            <option value="2" @if($user->status == 2) selected @endif >For Activation</option>
                                            <option value="3" @if($user->status == 3) selected @endif >Blocked</option>
                                            <option value="4" @if($user->status == 4) selected @endif >Deleted</option>
                                        </select>

                                    </td>
                                    <td><input id="dpo" type="checkbox" class="form-control" name="dpo" @if($user->dpo == 1) checked @endif disabled ></td>
                                    <td>{{$user->channel_id}}</td>
                                    <td>{{$user->created_at->toFormattedDateString()}}</td>
                                    <td><a class="mr-3" href="{{route('users.show', $user->id)}}"><span class="la la-eye"></span> View</a><a class="" href="{{route('users.edit', $user->id)}}"><span class="la la-pencil"></span> Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination mt-5 text-center">{{$users->appends(request()->query())->links()}}</div>
                        {{--<div class="m-pagination-center mt-5 text-center">{{ $thread->appends(request()->query())->links() }}</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection