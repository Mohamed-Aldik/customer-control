@extends('layouts.dashboard')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{__('Employees Violations')}}
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="#" class="">
            </a>
            <a href="{{route('dashboard.employees_violations.index')}}" class="btn btn-secondary">
                {{__('Back')}}
            </a>
        </div>
    </div>
</div>
<!-- end:: Content Head -->
<!--begin::Portlet-->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{__('Update Info')}}
            </h3>
        </div>
    </div>
    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.employees_violations.store')}}">
        @csrf

        <div class="kt-portlet__body">
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Employee')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <select class="form-control @error('employee_id') is-invalid @enderror kt-selectpicker"
                        id="employee_id" onchange="checkValidate()" data-size="7" data-live-search="true"
                        data-show-subtext="true" name="employee_id" title="{{__('Select')}}">
                        @forelse($employees as $employee)
                        <option value="{{$employee->id}}" @if($employee->id == (old('employee_id') ??
                            $employeeViolation->employee_id)) selected @endif
                            >{{$employee->job_number. ' ( ' . $employee->name() . ' )'}} </option>
                        @empty
                        <option disabled>{{__('There is no employees')}}</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Violation')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <select class="form-control @error('violation_id') is-invalid @enderror kt-selectpicker"
                        id="violation_id" onchange="checkValidate()" data-size="7" data-live-search="true"
                        data-show-subtext="true" name="violation_id" title="{{__('Select')}}">
                        @forelse($violations as $violation)
                        <option value="{{$violation->id}}" @if($violation->id == (old('violation_id') ??
                            $employeeViolation->violation_id)) selected @endif
                            >{{$violation->reason()}}</option>
                        @empty
                        <option disabled>{{__('There is no employees')}}</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Date')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <div class="input-group date">
                        <input name="date" onchange="checkValidate()" id='date_violation' value="{{ old('date') }}"
                            type="text" class="form-control datepicker" readonly />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row" id="minutes_late" style="display: none">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Minutes late')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('minutes_late') is-invalid @enderror" type="number" min="0"
                        value="{{ old('minutes_late') ?? $employeeViolation->minutes_late}}" id="minutes_late2"
                        name="minutes_late" onkeyup="checkValidate()">
                </div>
            </div>
            <div class="form-group row" id="absence_days" style="display: none">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Absence Days')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('absence_days') is-invalid @enderror" type="number" min="0"
                        value="{{ old('absence_days') ?? $employeeViolation->absence_days}}" id="absence_days2"
                        onkeyup="checkValidate()" placeholder="{{__('example: 1 hours = 60 minutes')}}"
                        name="absence_days">
                </div>
            </div>
            <div class="form-group pt-5" style="width: fit-content; margin: auto">
                <label class="text-center w-100">???????????? ???????????????? ???????? ??????</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio kt-radio--solid kt-radio--success">
                        <input type="radio" name="salary_type" value="basic_salary" checked
                            @if(old('salary_type')=='basic_salary' ) checked @endif>{{__('???????????? ??????????????')}}
                        <span></span>
                    </label>
                    <label class="kt-radio kt-radio--solid kt-radio--brand">
                        <input type="radio" name="salary_type" value="total_package"
                            @if(old('salary_type')=='total_package' ) checked @endif> {{__('???????????? ???????????????? ????????????????')}}
                        <span></span>
                    </label>
                </div>
                {{--                    <span class="form-text text-muted">Some help text goes here</span>--}}
            </div>
        </div>
        <div class="kt-portlet__foot" style="text-align: center">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12">
                        <button id="subbutton" disabled type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                        <a href="{{route('dashboard.employees_violations.index')}}"
                            class="btn btn-secondary">{{__('back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--end::Form-->
</div>

<!--end::Portlet-->

@endsection

@push('scripts')
<script src="{{asset('js/pages/employees_violations_form.js')}}"></script>
checkValidate();
@endpush