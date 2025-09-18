
<!-- Modal For Show Details-->
<div wire:ignore.self class="modal fade" id="formShowModal" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">

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
            <!--begin::Basic info-->
            {{--<div class="card {{ $class }}">--}}
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h4 class="fw-bolder m-0">{{ __('User Details') }}</h4>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Content-->
                <div id="kt_account_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <!--begin::Card body-->
                        <div class="card-body border-top p-9">
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
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Department/Office') }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select wire:model="office_id" class="form-select form-select-solid" id="show_office_id" disabled >
                                        <option value="0"> Select Department/Office </option>
                                        @foreach($listOfDepartment as $lod)
                                            <option  value="{{$lod->id}}">{{$lod->dept_name}}</option>
                                        @endforeach
                                    </select>
                                    <input wire:model="office" type="text" name="office" class="form-control form-control-lg form-control-solid" placeholder="Department / Office" value="{{ old('office', $office ?? '') }}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->


                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Email') }}</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input wire:model="email" type="text" name="office" class="form-control form-control-lg form-control-solid" placeholder="Email" value="{{ old('email', $email ?? '') }}" disabled/>
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
                        </div>
                        <!--end::Card body-->

                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                @include('partials.general._button-indicator', ['label' => __('Close')])
                            </button>
                        </div>
                        <!--end::Actions-->
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            {{--</div>--}}
            <!--end::Basic info-->

            <!--begin::Card header-->
            {{--<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">{{ __('Sign-in Method') }}</h3>
                </div>
            </div>--}}
            <!--end::Card header-->

            <!--begin::Content-->
            {{--<div id="kt_account_signin_method" class="collapse show">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Email Address-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        --}}{{--<div id="kt_signin_email">
                            <div class="fs-6 fw-bolder mb-1">{{ __('Email Address') }}</div>
                            <div class="fw-bold text-gray-600">{{ $email }}</div>
                        </div>--}}{{--
                        <!--end::Label-->

                        <!--begin::Edit-->
                        <div id="kt_signin_email_edit" class="flex-row-fluid">
                            <!--begin::Form-->
                            <form id="kt_signin_change_email" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changeEmail') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="current_email" value="{{ $email }} "/>
                                <div class="row mb-6">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="fv-row mb-0">
                                            <label for="email" class="form-label fs-6 fw-bolder mb-3">{{ __('Enter New Email Address') }}</label>
                                            <input type="email" class="form-control form-control-lg form-control-solid" placeholder="{{ __('Email Address') }}" name="email" value="{{ $email }}" id="email"/>
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
                                    <button id="kt_signin_submit" type="button" class="btn btn-primary  me-2 px-6">
                                        @include('partials.general._button-indicator', ['label' => __('Update Email')])
                                    </button>
                                    <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->

                        <!--begin::Action-->
                        --}}{{--<div id="kt_signin_email_button" class="ms-auto">
                            <button class="btn btn-light btn-active-light-primary">{{ __('Change Email') }}</button>
                        </div>--}}{{--
                        <!--end::Action-->
                    </div>
                    <!--end::Email Address-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-6"></div>
                    <!--end::Separator-->

                    <!--begin::Password-->
                    <div class="d-flex flex-wrap align-items-center mb-10">
                        <!--begin::Label-->
                        --}}{{--<div id="kt_signin_password">
                            <div class="fs-6 fw-bolder mb-1">{{ __('Password') }}</div>
                            <div class="fw-bold text-gray-600">************</div>
                        </div>--}}{{--
                        <!--end::Label-->

                        <!--begin::Edit-->
                        <div id="kt_signin_password_edit" class="flex-row-fluid">
                            <!--begin::Form-->
                            <form id="kt_signin_change_password" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changePassword') }}">
                                @csrf
                                @method('PUT')
                                <input wire:model="email" type="hidden" name="current_email" value="{{ $email }} "/>
                                <div class="row mb-1">
                                    <div class="col-lg-4">
                                        <div class="fv-row mb-0">
                                            <label for="current_password" class="form-label fs-6 fw-bolder mb-3">{{ __('Current Password') }}</label>
                                            <input type="password" class="form-control form-control-lg form-control-solid" name="current_password" id="current_password"/>
                                        </div>
                                    </div>

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

                                <div class="form-text mb-5">{{ __('Password must be at least 12 character and contain symbols') }}</div>

                                <div class="d-flex">
                                    <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">
                                        @include('partials.general._button-indicator', ['label' => __('Update Password')])
                                    </button>
                                    <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Edit-->

                        <!--begin::Action-->
                        --}}{{--<div id="kt_signin_password_button" class="ms-auto">
                            <button class="btn btn-light btn-active-light-primary">{{ __('Reset Password') }}</button>
                        </div>--}}{{--
                        <!--end::Action-->
                    </div>
                    <!--end::Password-->

                </div>
                <!--end::Card body-->
            </div>--}}
            <!--end::Content-->

            {{--<div class="modal-footer">
                <button class="btn btn-primary close-modal px-5" wire:click="edit({{$show_id}})" title="Edit Item"  data-bs-toggle="modal" data-bs-target="#formUpdateModal"> Edit</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>--}}
        </div>
    </div>
</div>
