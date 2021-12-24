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

    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-invoice-2">
            <div class="kt-invoice__head">
                <div style="width: 80%;
                            border: solid 1px;
                            padding: 20px;
                            margin-left: auto;
                            margin-right: auto;
                            margin-bottom: 50px;
                            position: relative;
                            font-size: 24px;
                        " class="page-content read container">

                    <img src="{{ asset('storage/companies/logos/'.$employeeViolation->employee->company->logo) }}"
                        style="margin: auto; display: table; height: 70px;" />

                    <h1 style="text-align: center;text-decoration: underline;padding: 10px; font-size: 30px">
                        {{__('Violation Letter')}}</h1>
                    <div class="details">
                        <p> <strong>{{__('Date')}} : </strong>
                            {{ \Carbon\Carbon::today()->locale(app()->getLocale())->isoFormat('LL') }}</p>
                        <!---<p> <strong>{{__('subject')}} : </strong> {{ __('deduction of wages') }}</p> -->
                        <p><strong> {{__('From')}} :</strong> {{ __('Human Resource Management') }}</p>
                        <p> <strong>{{__('Employee')}} : </strong>{{ $employeeViolation->employee->name() }}</p>
                        <p> <strong>{{__('Job Number')}} : </strong>{{ $employeeViolation->employee->job_number }}</p>


                        <!--<p><strong> {{__('From')}} :</strong> {{\App\Company::getHR() ? \App\Company::getHR()->name() : __('Human Resource Manager')}}</p>-->

                        @php
                        /*<p> <strong>{{__('Violation repeats')}} : </strong>{{ $employeeViolation->repeats }}</p>*/
                        @endphp
                    </div>


                    <p style="text-align: center;padding: 30px;">

                        @if ($employeeViolation->violation->message_ar != '')
                        {{ $employeeViolation->violation->message() }}
                        @else
                        {{__('Below has been sent to below, instructions below have been issued to below, and the penalty agreement issued below. We hope that this hotel will reward you to avoid violating work regulations in the future.')}}
                        @endif


                    </p>

                    <p style="margin: 10px 0"><strong>{{__('Violation Type')}}:
                        </strong>{{ $violation_type_message }}</p>
                    <p></p>

                    <p style="margin: 10px 0">
                        <strong> {{__('Violation date')}}: </strong>
                        {{ $employeeViolation->date->locale(app()->getLocale())->isoFormat('LL') }}
                    </p>

                    @if ($repeat_violation > 0)
                    <p> <strong>{{__('Violation repeats')}} : </strong>{{ $repeat_violation }}</p>
                    @endif

                    @if($employeeViolation->addition_to > 0)
                    <p style="margin: 10px 0"><strong>{{__('Violations Penalties')}}: </strong>
                        {{  number_format($employeeViolation->addition_to, 2) . ' '. __(' S.R')}}
                    </p>

                    @endif

                    <p style="margin: 10px 0"><strong> {{__('Addition Penalties')}}: </strong>
                        @php
                        $deduction2 = (float)$deduction;
                        $aaa = "";
                        if($deduction2 == 0){
                        $deduction = $deduction;
                        }else{
                        $deduction = number_format($deduction2, 2);
                        }
                        @endphp
                        {{ $deduction }}
                    </p>

                    @if($employeeViolation->addition_to > 0)

                    <p style="margin: 10px 0"><strong>{{__('Total Penalties')}} : </strong>
                        {{ number_format($total_penalties, 2) }} {{ __(' S.R')}}
                    </p>
                    @endif


                    <div style="
    text-align: left;
">
                        <p>{{ __('Director of Human Resources') }}</p>
                        <p>{{\App\Company::getHR() ? \App\Company::getHR()->name() : ''}}</p>


                        @php
                        /*<p style="margin: 10px 0"><strong>{{__('Addition Penalties')}} : </strong>
                            {{ '( ' . __($employeeViolation->violation->addition_to) . ' ' . ($employeeViolation->absence_days ??  $employeeViolation->minutes_late) . ' ) ' . $employeeViolation->addition_to . ' '. __(' S.R')}}
                        </p>
                        <p style="margin: 10px 0"><strong>{{__('Total Penalties')}} : </strong>
                            {{ $total_penalties }} {{ __(' S.R')}}
                        </p>

                        @endif
                        <p style="text-align: center">{{__('Wish you success')}}</p>

                        <div style="text-align: left;">
                            <p>{{__('Human Resource Manager')}}</p>
                            <p>{{\App\Company::getHR() ? \App\Company::getHR()->name() : ''}}</p>*/
                            @endphp


                        </div>

                        <div style="text-decoration: underline;">
                            <p>{{__('Reasons for the violation and the signature of receipt')}}:</p>
                            <p>{!! __('message0001') !!}</p>

                            <p style="width: 100%; height:8px;"></p>
                            <p style="width: 100%; height:2px; background: #333;"></p>
                            <p style="width: 100%; height:8px;"></p>
                            <p style="width: 100%; height:2px; background: #333;"></p>

                            <p>{{__('Signature')}}</p>
                            <p>{{__('Date')}}</p>
                        </div>
                    </div>
                </div>
                <div class="kt-invoice__actions">
                    <div class="kt-invoice__container">
                        <button type="button" class="btn btn-brand btn-bold"
                            onclick="window.print();">{{__('Print')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end::Portlet-->
    @endsection