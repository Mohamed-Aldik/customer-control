@extends('layouts.dashboard')
@push('styles')
<link href="{{asset('assets/css/pages/wizard/wizard-1.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item mt-4" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{__('Employees Services')}}
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="#" class="">
            </a>
            <a href="{{route('dashboard.index')}}" class="btn btn-secondary">
                {{__('Back')}}
            </a>
        </div>
    </div>
</div>
<!-- end:: Content Head -->

<div class="kt-portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{__('Vacation Request')}}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add"
            data-ktwizard-state="step-first">
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <!--begin: Form Wizard Form-->
                <form action="{{route('dashboard.vacations.update', $appRequest->id)}}" method="post" class="kt-form"
                    id="kt_contacts_add_form">

                    <input name="_method" type="hidden" value="PUT">

                    @csrf
                    <!--begin: Form Wizard Step 1-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-section kt-section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="kt-section__body">
                                            <div class="kt-section">
                                                <div class="kt-section__body">
                                                    <div class="kt-portlet__body">
                                                        <div class="form-group row ">
                                                            <div class="col-lg-4">
                                                                <label for="LeaveTypeId">
                                                                    {{__('Vacation Type')}}
                                                                </label>

                                                                <select disabled class="form-control kt-selectpicker"
                                                                    data-val="true" id="vacationTypes" id="vacation_id">
                                                                    <option value="">
                                                                        {{__('Choose')}}
                                                                    </option>

                                                                    @if ($sick_leave_used < 30) <option
                                                                        @if($vacationTypes[0]->id ==
                                                                        $vacation->vacation_type_id)
                                                                        selected
                                                                        @endif
                                                                        data-value="{{ (30-$sick_leave_used) }}"
                                                                        data-id='{{ $vacationTypes[0]->id }}'
                                                                        value="{{$vacationTypes[0]->id}}">
                                                                        {{$vacationTypes[0]->name()}} </option>
                                                                        @endif

                                                                        @if ($sick_leave_used >= 30)
                                                                        <option @if ($vacationTypes[1]->id ==
                                                                            $vacation->vacation_type_id)
                                                                            selected
                                                                            @endif
                                                                            data-value="{{ (90-$sick_leave_used) }}"
                                                                            data-id='{{ $vacationTypes[1]->id }}'
                                                                            value="{{$vacationTypes[1]->id}}">
                                                                            {{$vacationTypes[1]->name()}} </option>
                                                                        @endif

                                                                        @if ($sick_leave_used >= 90)
                                                                        <option @if ($vacationTypes[2]->id ==
                                                                            $vacation->vacation_type_id)
                                                                            selected
                                                                            @endif
                                                                            data-value="{{ (120-$sick_leave_used) }}"
                                                                            data-id='{{ $vacationTypes[2]->id }}'
                                                                            value="{{$vacationTypes[2]->id}}">
                                                                            {{$vacationTypes[2]->name()}} </option>
                                                                        @endif


                                                                        @foreach($vacationTypes as $vacationType)
                                                                        @if ($vacationType->id <= 3) @else <option
                                                                            @if(($vacationType->id ==
                                                                            $vacation->vacation_type_id))
                                                                            selected
                                                                            @endif
                                                                            value="{{$vacationType->id}}"
                                                                            data-value="{{$vacationType->num_of_days}}"
                                                                            data-id='{{ $vacationType->id }}'>
                                                                            {{$vacationType->name()}}</option>
                                                                            @endif

                                                                            @endforeach




                                                                            <option data-value="" value="Other">
                                                                                {{__('Other')}}</option>


                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label for="start_date">{{__('Start Date')}}<span
                                                                        class="required">*</span></label>
                                                                <div class="input-group date">
                                                                    <input disabled
                                                                        value="{{ date('Y-m-d', strtotime($vacation->start_date)) }}"
                                                                        type="text"
                                                                        class="form-control start_date datepicker"
                                                                        readonly />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label for="end_date">{{__('Vacation Days')}}<span
                                                                        class="required">*</span></label>
                                                                <div class="input-group date">
                                                                    <input name="vacation_days"
                                                                        value="{{ $vacation->total_days }}"
                                                                        type="number" class="form-control end_date" />
                                                                    <input name="end_date" type="text"
                                                                        class="form-control end_date2 datepicker"
                                                                        readonly style="display: none" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="display: none" id="reason">
                                                            <div class="col-lg-6">
                                                                <label>{{__('Reason In Arabic')}}</label>
                                                                <input name="reason_ar" value="{{old('reason_ar')}}"
                                                                    class="form-control @error('reason_ar') is-invalid @enderror">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('Reason In English')}}</label>
                                                                <input name="reason_en" value="{{old('reason_en')}}"
                                                                    class="form-control @error('reason_en') is-invalid @enderror">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="display: none">

                                                            <div class="col-6">
                                                                <div class="row">
                                                                    <label
                                                                        class="col-6 col-form-label">{{__('Paid In Advance')}}</label>
                                                                    <div class="col-6">
                                                                        <span class="kt-switch kt-switch--icon">
                                                                            <label>
                                                                                <input type="checkbox" disabled
                                                                                    @if(old('paid_in_advance')) checked
                                                                                    @endif name="paid_in_advance"
                                                                                    id="paid_in_advance">
                                                                                <span></span>
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                @if (auth()->user()->nationality_id != 3)
                                                                <div class="row">
                                                                    <label
                                                                        class="col-6 col-form-label">{{__('Ticket Request')}}</label>
                                                                    <div class="col-6">
                                                                        <span class="kt-switch kt-switch--icon">
                                                                            <label>
                                                                                <input id="ticket_request" disabled
                                                                                    type="checkbox" value="1"
                                                                                    name="ticket_request">
                                                                                <span></span>
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <label
                                                                        class="col-6 col-form-label">{{__('Visa Request')}}</label>
                                                                    <div class="col-6">
                                                                        <span class="kt-switch kt-switch--icon">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    name="visa_request">
                                                                                <span></span>
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                @endif


                                                            </div>



                                                            <div class="col-6 show_if_paid_in_advance"
                                                                style="display: none;">
                                                                <div
                                                                    class="kt-portlet kt-portlet--unelevate kt-portlet--bordered">
                                                                    <div class="kt-portlet__body text-center">
                                                                        <table class="table table-striped"
                                                                            style="margin-bottom: 0;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">الراتب المسبق الدفع
                                                                                    </th>
                                                                                    <td class="salary_Paid_in_advance">-
                                                                                        - - - -</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-3">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div
                                                                    class="kt-portlet kt-portlet--unelevate kt-portlet--bordered">
                                                                    <div class="kt-portlet__body text-center">
                                                                        <span class="display-4"
                                                                            id="vacation_days"></span>
                                                                        <span>تاريخ أخر يوم بالأجازه <span
                                                                                id="end_date01"></span> </span>
                                                                        <span>تاريخ العوده <span
                                                                                id="return_date"></span> </span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6"
                                                                style="display: none;">
                                                                <div
                                                                    class="kt-portlet kt-portlet--unelevate kt-portlet--bordered">
                                                                    <div class="row">

                                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                                            <div class="kt-portlet__body text-center">
                                                                                <span class="display-4">
                                                                                    {{ auth()->user()->leave_balance ?? 0 }}
                                                                                </span>
                                                                                {{__('Annual balance')}}
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                                            <div class="kt-portlet__body text-center">
                                                                                <span
                                                                                    class="display-4 available_balance">
                                                                                    {{ $available_balance ?? 0 }}
                                                                                </span>
                                                                                {{__('Available Balance')}}
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                                            <div class="kt-portlet__body text-center">
                                                                                <span class="display-4">
                                                                                    {{ auth()->user()->usedBalance() ?? 0 }}
                                                                                </span>
                                                                                {{__('Used balance')}}
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 1-->
                    <!--begin: Form Actions -->
                    <div class="kt-form__actions">
                        <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto"
                            style="display: block" data-ktwizard-type="action-submit">
                            {{__('confirm')}}
                        </div>
                    </div>

                    <!--end: Form Actions -->
                </form>

                <!--end: Form Wizard Form-->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/pages/vacation_request_form_num2.js')}}" type="text/javascript"></script>
@endpush