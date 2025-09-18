@extends('vtt.layouts.main')

@section('content')
    {{--<div class="row">--}}
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users.index')}}"><span class="lnr-users2"></span>  User Archive</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="lnr-user-plus"></span> Create New User</li>
                </ol>
            </nav>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="lnr-user-plus"></span> Create New User <a href="{{route('users.index')}}" class="btn btn-secondary float-right"><span class="lnr-list"></span> View All User</a></h3>
                </div>
                <form action="{{route('users.store')}}" method="POST">
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        {{--<span ><b-form-checkbox name="showPassword" class="mt-2" id="showPassword"> Show Password? </b-form-checkbox></span>--}}

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="roles" class="label">Roles:</label>
                                <b-form-group v-cloak>
                                    <b-form-checkbox-group id="rolesCheckboxes" name="roles">
                                    @foreach ($roles as $role)
                                        <div>
                                           <b-form-checkbox v-model="roleselected" value="{{$role->id}}">{{$role->display_name}}</b-form-checkbox>
                                        </div>
                                    @endforeach
                                    </b-form-checkbox-group>
                                </b-form-group>
                                <input type="hidden" name="roles" :value="roleselected" />
                                {{--<div>Selected: <strong>@{{ roleselected }}</strong></div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary px-5"><span class="lnr-floppy-disk"></span> Create New User</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    {{--</div>--}}
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/app8.js') }}"></script>--}}
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                auto_password: true,
                roleselected: [{!! old('roles') ? old('roles') : '' !!}],
            }
        });

        $(document).ready(function() {

            $('.js-basic-single').select2();


        });
    </script>
@endsection
