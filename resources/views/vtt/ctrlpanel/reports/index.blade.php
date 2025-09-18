@extends('layouts.ctrlpanel')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-graph"></span> Reports</li>
                </ol>
            </nav>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-graph"></span> Reports</h3>
                </div>
                <div class="box-body">
                    <div class="py-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-3">
                                <div class="dashboard dashboard-primary">
                                    <a href="{{route('reports-lastlogin')}}" class="dashboard-link">
                                        <span class="dashboard-icon"><span class="lnr-calendar-user"></span></span>
                                        <span class="dashboard-body">User's Last Login</span>
                                    </a>
                                </div>
                            </div>
                            {{--<div class="col-md-4 col-lg-3">--}}
                                {{--<div class="dashboard dashboard-success">--}}
                                    {{--<a href="/updateStatus/thread/1" class="dashboard-link">--}}
                                        {{--<span class="dashboard-icon"><span class="lnr-bubbles"></span><span class="float-right m-badge m-badge--success">2</span></span>--}}
                                        {{--<span class="dashboard-body">Approved Thread</span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4 col-lg-3">--}}
                                {{--<div class="dashboard dashboard-warning">--}}
                                    {{--<a href="/updateStatus/channel/0" class="dashboard-link">--}}
                                        {{--<span class="dashboard-icon"><span class="lnr-list2"></span><span class="float-right m-badge m-badge--warning">3</span></span>--}}
                                        {{--<span class="dashboard-body">Channel for Approval</span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4 col-lg-3">--}}
                                {{--<div class="dashboard dashboard-info">--}}
                                    {{--<a href="/updateStatus/channel/1" class="dashboard-link">--}}
                                        {{--<span class="dashboard-icon"><span class="lnr-list3"></span><span class="float-right m-badge m-badge--info">4</span></span>--}}
                                        {{--<span class="dashboard-body">Approved Channel</span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection