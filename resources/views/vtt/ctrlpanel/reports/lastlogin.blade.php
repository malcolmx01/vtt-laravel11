@extends('layouts.ctrlpanel')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('reports')}}"><span class="lnr-graph"></span> Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-calendar-user"></span> Last Login</li>
                </ol>
            </nav>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-calendar-user"></span> Last Login</h3>
                </div>
                <div class="box-body">
                    <form  id="lastlogins" action="{{action('ReportsController@lastlogin')}}" method="GET" role="ul" class="m-form">
                        {{ csrf_field() }}
                        Filter By:
                        <select name="ul" class="category form-control m-input--square square">
                            <option value="">Select Logs Reports</option>
                            <option value="1" @if(Request::get('ul')=='1') selected @endif >This Week</option>
                            <option value="2" @if(Request::get('ul')=='2') selected @endif >Last Week</option>
                            <option value="3" @if(Request::get('ul')=='3') selected @endif >Last Month</option>
                            <option value="4" @if(Request::get('ul')=='4') selected @endif >More than a Month</option>
                        </select>
                    </form>
                    <div class="table-responsive mt-5">
                        <table class="table">
                            <thead>
                            <tr class="bg-light">
                                <th>@sortablelink('username','UserName')</th>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('email','Email')</th>
                                <th>@sortablelink('last_login','Date Time')</th>
                                <th>@sortablelink('last_login','Last Login')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>{{$user->username}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->last_login}}</td>
                                    <td>@if(!empty($user->last_login)) {{$user->last_login->diffForHumans()}} @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination mt-5 text-center">{{ $users->appends(request()->query())->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

    <script>
        $(document).ready(function(){
            $('#lastlogins').on('change', function(e){
                $(this).closest('form').submit();
            });
        });
    </script>

@endsection