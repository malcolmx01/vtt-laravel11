
<!-- Modal For Show Details-->
<div wire:ignore.self class="modal fade" id="formUpdateModal" tabindex="-1">
    {{--<div class="modal-dialog modal-xl" role="document">--}}
    <div class="modal-dialog modal-dialog-scrollable modal-primary modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="formModalLabel">User Profile</h2>
                <div>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 x-button" data-bs-dismiss="modal" aria-label="Close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg>
                            </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm mb-5">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_user_account_profile_details" aria-expanded="true" aria-controls="kt_user_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h4 class="fw-bolder m-0">{{ __('User Details') }}</h4>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <div id="kt_user_account_profile_details" class="collapse show">

                        <!--begin::Form-->
                        <form id="kt_user_account_profile_details_form" class="form" method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!--begin::card-body-->
                            <div class="card-body">
                                <!--begin::Basic info-->
                                <!--begin::Content-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Avatar') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Image input-->
                                            <div wire:model="avatar" class="image-input image-input-outline {{ isset($info) && $avatar ? '' : 'image-input-empty' }}" data-kt-image-input="true" style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})">
                                                <!--begin::Preview existing avatar-->
                                                <div wire:model="avatar" class="image-input-wrapper w-125px h-125px" style="background-image: {{ $avatar ? 'url('.asset('storage/'.$avatar).')'  : 'none' }};"></div>
                                                <!--end::Preview existing avatar-->

                                                <!--begin::Label-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="avatar_remove"/>
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->

                                                <!--begin::Cancel-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                                                <!--end::Cancel-->

                                                <!--begin::Remove-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->

                                            <!--begin::Hint-->
                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Full Name') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-6 fv-row">
                                                    <input wire:model="show_id" type="hidden" name="show_id" value="{{$show_id}}"/>
                                                    <input wire:model="first_name" type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{ old('first_name', $first_name ?? ''  /*auth()->user()->first_name ?? ''*/) }}"/>
                                                </div>
                                                <!--end::Col-->

                                                <!--begin::Col-->
                                                <div class="col-lg-6 fv-row">
                                                    <input wire:model="last_name" type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="{{ old('last_name', $last_name ?? '') }}"/>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Company') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input wire:model="company" type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="{{ old('company', $company ?? '') }}"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                                            <span class="required">{{ __('Contact Phone') }}</span>

                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('Phone number must be active') }}"></i>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input wire:model="phone"  type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{ old('phone', $phone ?? '') }}"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6" required>{{ __('Department/Office') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <div wire:ignore >
                                                <select wire:model="office_id" name="office_id" data-dropdown-parent="#formUpdateModal" tabindex="-1" data-control="select2" data-placeholder="Select Department/Office" class="form-select form-select-solid @if($errors->has('office_id')) is-invalid @endif" id="office_id_update" >
                                                    <option value="0"> Select Department/Office </option>
                                                    @foreach($listOfDepartment as $lod)
                                                        <option  value="{{$lod->id}}">{{$lod->dept_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--@error('office_id') <span class="invalid-feedback">{{ $message }}</span>@enderror--}}
                                            </div>
                                            {{--<input wire:model="office" type="text" name="office" class="form-control form-control-lg form-control-solid" placeholder="Department / Office" value="{{ old('office', $office ?? '') }}"/>--}}
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6" required>{{ __('Assigned Employee') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <div wire:ignore >
                                                <select wire:model="employee_id" name="employee_id" data-dropdown-parent="#formUpdateModal" tabindex="-1" data-control="select2" data-placeholder="Select Department/Office" class="form-select form-select-solid @if($errors->has('employee_id')) is-invalid @endif" id="employee_id_update" >
                                                    <option value="0"> Select Assigned Employee </option>
                                                    @foreach($listOfEmployee as $lod)
                                                        <option  value="{{$lod->id}}">{{$lod->first_name}} {{$lod->last_name}} / {{$lod->position}} / {{$lod->department}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Email') }}</label>
                                        <!--end::Label-->
                                        <div class="col-lg-8 fv-row">
                                            <input wire:model="email" type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email" value="{{ old('email', $email ?? '') }}" disabled/>
                                        </div>
                                    </div>
                                    <!--begin::Input group-->
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Communication') }}</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <!--begin::Options-->
                                            <div class="d-flex align-items-center mt-3">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid me-5">
                                                    <input type="hidden" name="communication[email]" value="0">
                                                    <input class="form-check-input" name="communication[email]" type="checkbox" value="1" {{ old('marketing', $info->communication['email'] ?? '') ? 'checked' : '' }}/>
                                                    <span class="fw-bold ps-2 fs-6">
                                    {{ __('Email') }}
                                </span>
                                                </label>
                                                <!--end::Option-->

                                                <!--begin::Option-->
                                                <label class="form-check form-check-inline form-check-solid">
                                                    <input type="hidden" name="communication[phone]" value="0">
                                                    <input class="form-check-input" name="communication[phone]" type="checkbox" value="1" {{ old('email', $info->communication['phone'] ?? '') ? 'checked' : '' }}/>
                                                    <span class="fw-bold ps-2 fs-6">
                                    {{ __('Phone') }}
                                </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-0">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Approved') }}</label>
                                        <!--begin::Label-->

                                        <!--begin::Label-->
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <div class="form-check form-check-solid form-switch fv-row">
                                                <input type="hidden" name="approved" value="0">
                                                <input wire:model="approved" class="form-check-input w-45px h-30px" type="checkbox" id="approved" name="approved" value="1" {{ $approved == 1 ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="approved"></label>
                                            </div>
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Input group-->
                                <!--end::Content-->
                                <!--end::Basic info-->
                            </div>
                            <!--end::card-body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-white btn-active-light-primary me-2" data-bs-dismiss="modal">{{ __('Discard') }}</button>

                            <button type="submit" class="btn btn-primary" id="kt_user_account_profile_details_submit">
                                @include('partials.general._button-indicator', ['label' => __('Save Changes')])
                            </button>
                        </div>
                        <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>


                <div class="card shadow-sm mb-5 {{ $class ?? '' }}" {{ util()->putHtmlAttributes(array('id' => $id ?? '')) }}>
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_user_account_signin_method">
                        <div class="card-title m-0">
                            <h4 class="fw-bolder m-0">{{ __('Sign-in Method') }}</h4>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Content-->
                    <div id="kt_user_account_signin_method" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Email Address-->
                            <div class="d-flex flex-wrap align-items-center">
                                <!--begin::Label-->
                                <div id="kt_user_signin_email" class="row">
                                    <div class="fs-6 fw-bolder mb-1">{{ __('Email Address') }}</div>
                                    <div class="fw-bold text-gray-600"><input wire:model="email" type="text" class="form-control form-control-lg form-control-solid" name="email" placeholder="Email" value="{{ old('email', $email ?? '') }}" disabled /></div>

                                </div>
                                <!--end::Label-->

                                <!--begin::Edit-->
                                <div id="kt_user_signin_email_edit" class="flex-row-fluid d-none">
                                    <!--begin::Form-->
                                    <form id="kt_user_signin_change_email" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changeUserEmail') }}">
                                        @csrf
                                        @method('PUT')
                                        <input wire:model="show_id" type="hidden" name="show_id" value="{{ old('show_id', $show_id ?? '') }}"  />
                                        <input wire:model="email" type="hidden" name="current_email" value="{{ old('email', $email ?? '') }}"  />
                                        <div class="row mb-6">
                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                <div class="fv-row mb-0">
                                                    <label for="email" class="form-label fs-6 fw-bolder mb-3">{{ __('Enter New Email Address') }}</label>
                                                    <input type="email" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" id="email"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="fv-row mb-0">
                                                    <label for="current_password" class="form-label fs-6 fw-bolder mb-3">{{ __('Confirm Password') }}</label>
                                                    <input type="password" class="form-control form-control-lg form-control-solid" name="current_password" id="current_password"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <button id="kt_user_signin_submit" type="button" class="btn btn-primary  me-2 px-6">
                                                @include('partials.general._button-indicator', ['label' => __('Update Email')])
                                            </button>
                                            <button id="kt_user_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Edit-->

                                <!--begin::Action-->
                                <div id="kt_user_signin_email_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">{{ __('Change Email') }}</button>
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Email Address-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-6"></div>
                            <!--end::Separator-->

                            <!--begin::Password-->
                            <div class="d-flex flex-wrap align-items-center mb-10">
                                <!--begin::Label-->
                                <div id="kt_user_signin_password">
                                    <div class="fs-6 fw-bolder mb-1">{{ __('Password') }}</div>
                                    <div class="fw-bold text-gray-600">************</div>
                                </div>
                                <!--end::Label-->

                                <!--begin::Edit-->
                                <div id="kt_user_signin_password_edit" class="flex-row-fluid d-none">
                                    <!--begin::Form-->
                                    <form id="kt_user_signin_change_password" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changeUserPassword') }}">
                                        @csrf
                                        @method('PUT')
                                        <input wire:model="show_id" type="hidden" name="show_id" value="{{ old('show_id', $show_id ?? '') }}"  />
                                        <div class="row mb-1">
                                            {{--<div class="col-lg-4">
                                                <div class="fv-row mb-0">
                                                    <label for="current_password" class="form-label fs-6 fw-bolder mb-3">{{ __('Current Password') }}</label>
                                                    <input type="password" class="form-control form-control-lg form-control-solid" name="current_password" id="current_password"/>
                                                </div>
                                            </div>--}}

                                            <div class="col-lg-4">
                                                <div class="fv-row mb-0">
                                                    <label for="password" class="form-label fs-6 fw-bolder mb-3">{{ __('New Password') }}</label>
                                                    <input type="password" class="form-control form-control-lg form-control-solid" name="password" id="password"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="fv-row mb-0">
                                                    <label for="password_confirmation" class="form-label fs-6 fw-bolder mb-3">{{ __('Confirm New Password') }}</label>
                                                    <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" id="password_confirmation"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-text mb-5">{{ __('Password must be at least 8 character and contain symbols') }}</div>

                                        <div class="d-flex">
                                            <button id="kt_user_password_submit" type="button" class="btn btn-primary me-2 px-6">
                                                @include('partials.general._button-indicator', ['label' => __('Update Password')])
                                            </button>
                                            <button id="kt_user_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Edit-->

                                <!--begin::Action-->
                                <div id="kt_user_signin_password_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">{{ __('Reset Password') }}</button>
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Password-->

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>


        </div>

    </div>
</div>


@section('scripts')
    <script type="text/javascript">

    "use strict";

    // On document ready
    $(document).ready(function() {
        KTUtil.onDOMContentLoaded(function () {
            KTAccountSettingsSigninMethods.init();
        });

        window.livewire.on('showDefaultValue', data => {
            if(data.office_id !== 'undefined' && data.office_id !== ''){
                $("#office_id_update").select2().val(data.office_id).trigger("change");
            }else {
                $("#office_id_update").select2();
            }

            $('#office_id_update').on('change', function (e) {
                console.log('data: ' + e.target.value);
                @this.set('office_id', e.target.value);
            });

            if(data.employee_id !== 'undefined' && data.employee_id !== ''){
                $("#employee_id_update").select2().val(data.employee_id).trigger("change");
            }else{
                $("#employee_id_update").select2();
            }

            $('#employee_id_update').on('change', function (e) {
                console.log('data: ' + e.target.value);
                        @this.set('employee_id', e.target.value);
            });
        });
    });


    // Class definition
    var KTAccountSettingsSigninMethods = function () {

        // Private functions
        var initSettings = function () {

            // UI elements
            var signInMainEl = document.getElementById('kt_user_signin_email');
            var signInEditEl = document.getElementById('kt_user_signin_email_edit');
            var passwordMainEl = document.getElementById('kt_user_signin_password');
            var passwordEditEl = document.getElementById('kt_user_signin_password_edit');

            // button elements
            var signInChangeEmail = document.getElementById('kt_user_signin_email_button');
            var signInCancelEmail = document.getElementById('kt_user_signin_cancel');
            var passwordChange = document.getElementById('kt_user_signin_password_button');
            var passwordCancel = document.getElementById('kt_user_password_cancel');

            // toggle UI
            signInChangeEmail.querySelector('button').addEventListener('click', function () {
                toggleChangeEmail();
            });

            signInCancelEmail.addEventListener('click', function () {
                toggleChangeEmail();
            });

            passwordChange.querySelector('button').addEventListener('click', function () {
                toggleChangePassword();
            });

            passwordCancel.addEventListener('click', function () {
                toggleChangePassword();
            });

            var toggleChangeEmail = function () {
                signInMainEl.classList.toggle('d-none');
                signInChangeEmail.classList.toggle('d-none');
                signInEditEl.classList.toggle('d-none');
            }

            var toggleChangePassword = function () {
                passwordMainEl.classList.toggle('d-none');
                passwordChange.classList.toggle('d-none');
                passwordEditEl.classList.toggle('d-none');
            }
        }

        var handleUserChangeEmail = function (e) {
            var validation;

            // form elements
            var form = document.getElementById('kt_user_signin_change_email');
            var submitButton = form.querySelector('#kt_user_signin_submit');

            validation = FormValidation.formValidation(
                form,
                {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email is required'
                                },
                                emailAddress: {
                                    message: 'The value is not a valid email address'
                                }
                            }
                        },

                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                }
                            }
                        }
                    },

                    plugins: { //Learn more: https://formvalidation.io/guide/plugins
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row'
                        })
                    }
                }
            );

            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validation.validate().then(function (status) {
                    if (status === 'Valid') {

                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Send ajax request
                        axios.post(form.getAttribute('action'), new FormData(form))
                            .then(function (response) {
                                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "Your email has been successfully changed.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            })
                            .catch(function (error) {
                                let dataMessage = error.response.data.message;
                                let dataErrors = error.response.data.errors;

                                for (const errorsKey in dataErrors) {
                                    if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                    dataMessage += "\r\n" + dataErrors[errorsKey];
                                }

                                if (error.response) {
                                    Swal.fire({
                                        text: dataMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            })
                            .then(function () {
                                // always executed
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });

                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                });
            });
        }

        var handleUserChangePassword = function (e) {

            var validation;

            // form elements
            var form = document.getElementById('kt_user_signin_change_password');
            var submitButton = form.querySelector('#kt_user_password_submit');

            validation = FormValidation.formValidation(
                form,
                {
                    fields: {
                        current_password: {
                            validators: {
                                notEmpty: {
                                    message: 'Current Password is required'
                                }
                            }
                        },

                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'New Password is required'
                                }
                            }
                        },

                        password_confirmation: {
                            validators: {
                                notEmpty: {
                                    message: 'Confirm Password is required'
                                },
                                identical: {
                                    compare: function () {
                                        return form.querySelector('[name="password"]').value;
                                    },
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                    },

                    plugins: { //Learn more: https://formvalidation.io/guide/plugins
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row'
                        })
                    }
                }
            );

            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validation.validate().then(function (status) {
                    if (status == 'Valid') {

                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Send ajax request
                        axios.post(form.getAttribute('action'), new FormData(form))
                            .then(function (response) {
                                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "Your password has been successfully reset.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            })
                            .catch(function (error) {
                                let dataMessage = error.response.data.message;
                                let dataErrors = error.response.data.errors;

                                for (const errorsKey in dataErrors) {
                                    if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                    dataMessage += "\r\n" + dataErrors[errorsKey];
                                }

                                if (error.response) {
                                    Swal.fire({
                                        text: dataMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            })
                            .then(function () {
                                // always executed
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });

                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        });
                    }
                });
            });
        }

        // Public methods
        return {
            init: function () {
                initSettings();
                handleUserChangeEmail();
                handleUserChangePassword();
            }
        }
    }();

    </script>
@endsection
