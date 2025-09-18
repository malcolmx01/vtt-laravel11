@extends('vtt.layouts.main')

@section('page','Users')
@section('description','Create New User')
@section('header-component')
    <a href="#" class="btn kt-subheader__btn-primary">
        Actions &nbsp;
        <i class="flaticon2-calendar-1"></i>
    </a>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">User Information</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{route('users.index')}}" class="btn btn-default btn-icon-sm">
                                <i class="la la-list-ol"></i>
                                User Archive
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <form class="kt-form kt-form--label-right" action="{{route('users.store')}}" method="POST">
                {{csrf_field()}}
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">

                            <div class="form-group row">
                                <label for="name" class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
                                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-xl-3 col-lg-3 col-form-label">{{ __('E-Mail Address') }}</label>

                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                    </div>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-xl-3 col-lg-3 col-form-label">{{ __('Password') }}</label>

                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock"></i></span></div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="password"  required>
                                    </div>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-xl-3 col-lg-3 col-form-label">{{ __('Confirm Password') }}</label>

                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock"></i></span></div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3">
                            </div>
                            <div class="col-lg-9 col-xl-9">
                                <button type="submit" class="btn btn-success">Submit</button>&nbsp;
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
