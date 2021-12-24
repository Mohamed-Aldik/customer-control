@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Payrolls')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.payrolls.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    @if($payroll->has_changes)
        <div class="alert alert-primary" role="alert">

            <div class="alert-icon"><i class="flaticon-warning"></i></div>

            <div class="alert-text">
                <strong>
                    {{__('There is salary operations not included in payroll. Please reissue the payroll to include operation')}}
                </strong>
            </div>
        </div>
    @endif
    <!-- end:: Content Head -->
    <div class="kt-portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Payroll Details')}}
                </h3>
            </div>
        </div>
        @if(session('reissue') == 1)
            <div class="kt-portlet__body" id="reissue_alert">
                <div class="alert alert-warning" style="margin: 0" role="alert">
                    <div class="alert-text">{{__('The Payroll  Has Been Reissued !')}}</div>
                </div>
            </div>
        @endif
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-xl">

                <div class="col-md-12 col-lg-12 col-xl-4">

                    <!--begin:: Widgets/Stats2-3 -->
                    <div class="kt-widget1">
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Payrolls')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{ $payroll->date->translatedFormat('F Y') }}
                                </span>
                            </div>

                        </div>

                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Employees No')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{ $payroll->employees_no }}
                                </span>
                            </div>

                        </div>

                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Payroll Date')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{ $payroll->date->format('d-m-Y') }}
                            </span>
                            </div>

                        </div>
                    </div>

                    <!--end:: Widgets/Stats2-3 -->
                </div>

                <div class="col-md-12 col-lg-12 col-xl-4">

                    <!--begin:: Widgets/Stats2-1 -->
                    <div class="kt-widget1">
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Status')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                    @switch($payroll->status)
                                        @case('0')
                                        <span class="kt-badge kt-badge--primary kt-badge--inline kt-badge--pill kt-badge--rounded">
                                                {{__('Pending')}}
                                            </span>
                                        @break
                                        @case('1')
                                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">
                                                {{__('Approved')}}
                                            </span>
                                        @break
                                        @case('2')
                                        <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">
                                                {{__('Rejected')}}
                                            </span>
                                        @break
                                    @endswitch
                                </span>
                            </div>

                        </div>
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Operations Included')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                    <span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--pill kt-badge--rounded">
                                        {{__('Deductions')}}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Issue Date')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{$payroll->issue_date->format('A h:i @ d-m-Y')}}
                            </span>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Stats2-1 -->
                </div>

                <div class="col-md-12 col-lg-12 col-xl-4">

                    <!--begin:: Widgets/Stats2-2 -->
                    <div class="kt-widget1">

                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Total Deductions')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{__('Total salaries deductions')}}
                            </span>
                            </div>
                            <span class="kt-widget1__number kt-font-danger">
                                {{$payroll->total_deductions}}
                            </span>
                        </div>

                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Total Allowances')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{__('Total salaries deductions')}}
                            </span>
                            </div>
                            <span class="kt-widget1__number kt-font-success">
                                {{$payroll->total_allowances}}
                            </span>
                        </div>

                        <div class="kt-widget1__item">
                            <div class="kt-widget1__info">
                                <h3 class="kt-widget1__title">
                                    {{__('Payroll total netpay')}}
                                </h3>
                                <span class="kt-widget1__desc">
                                {{__('Total netpay after deductions')}}
                            </span>
                            </div>
                            <span class="kt-widget1__number kt-font-success">
                                {{$payroll->total_net_salary}}
                            </span>
                        </div>

                    </div>
                    <!--end:: Widgets/Stats2-2 -->
                </div>


            </div>
        </div>
    </div>

    <div>
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title kt-font-brand">
                        {{ $payroll->date->translatedFormat('F Y') }}
                        <small>
                            {{ $payroll->date->format('d-m-Y') }}
                        </small>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        @can('proceed_payrolls')
{{--                            @if($payroll->status != 1)--}}
                            <a class="btn btn-warning btn-sm btn-loading" id="reissue-btn3" href="#">
                                <i class="fa fa-dollar-sign"></i>
                                {{__('Overtime+')}}
                            </a>
                            <a class="btn btn-warning btn-sm btn-loading" id="reissue-btn2" href="#">
                                <i class="fa fa-dollar-sign"></i>
                                {{__('Financial Move')}}
                            </a>
                            <a class="btn btn-warning btn-sm btn-loading" id="reissue-btn" href="#">
                                <i class="fa fa-redo"></i>
                                {{__('Reissue')}}
                            </a>
                            <a href="{{route('dashboard.payrolls.approve', $payroll->id)}}" class="btn btn-success btn-sm ">
                                <i class="fa fa-check"></i>
                                {{__('Approve')}}
                            </a>
                            <a href="{{route('dashboard.payrolls.reject', $payroll->id)}}" class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i>
                                {{__('Reject')}}
                            </a>
{{--                            @endif--}}
                        @endcan
                        <a href="{{route('dashboard.payrolls.excel', $payroll->id)}}" class="btn btn-primary btn-sm">
                            <i class="la la-file-excel-o"></i>
                            {{__('Export')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                        <div class="row align-items-center">
                            <div class="col-xl-12 order-2 order-xl-1">
                                <div class="row align-items-center">
                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Search')}}:</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="kt-input-icon kt-input-icon--left">
                                                    <input type="text" class="form-control" id="generalSearch">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                    <span><i class="la la-search"></i></span>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Supervisor')}}:</label>

                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <select class="form-control selectpicker" id="kt_form_supervisor">
                                                    <option value="">{{__('All')}}</option>
                                                    @forelse($supervisors as $supervisor)
                                                        <option value="{{$supervisor->name()}}">{{$supervisor->name()}}</option>
                                                    @empty
                                                        <option disabled>{{__('There is no supervisors in your company')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Nationality')}}:</label>

                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <select class="form-control selectpicker" id="kt_form_nationality">
                                                    <option value="">{{__('All')}}</option>
                                                    @forelse($nationalities as $nationality)
                                                        <option value="{{$nationality->name()}}">{{$nationality->name()}}</option>
                                                    @empty
                                                        <option disabled>{{__('There is no nationalities in your company')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row align-items-center ">
                            <div class="col-xl-12 order-2 order-xl-1">
                                <div class="row align-items-center">


                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Provider')}}:</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <select class="form-control selectpicker" id="kt_form_provider">
                                                    <option value="">{{__('All')}}</option>
                                                    @forelse($providers as $provider)
                                                        <option value="{{$provider->name()}}">{{$provider->name()}}</option>
                                                    @empty
                                                        <option disabled>{{__('There is no providers in your company')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Section')}}:</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <select class="form-control selectpicker" id="kt_form_section">
                                                    <option value="">{{__('All')}}</option>
                                                    @forelse($sections as $section)
                                                        <option value="{{$section->name()}}">{{$section->name()}}</option>
                                                    @empty
                                                        <option disabled>{{__('There is no sections in your company')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Department')}}:</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <select class="form-control selectpicker" id="kt_form_department">
                                                    <option value="">{{__('All')}}</option>
                                                    @forelse($departments as $department)
                                                        <option value="{{$department->name()}}">{{$department->name()}}</option>
                                                    @empty
                                                        <option disabled>{{__('There is no departments in your company')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- end:: Content Head -->
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">

                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="scrolling_horizontal"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    <!--end::Portlet-->

    <div class="modal fade" id="reissue-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Reissue')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right update-attendance-form" method="get" action="{{route('dashboard.payrolls.reissue', $payroll->id)}}">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row d-flex justify-content-center">
                                <label class="col-3 col-form-label">{{__('Calculation based on attendance')}}</label>
                                <div class="col-3">
                                    <span class="kt-switch kt-switch--icon">
                                        <label>
                                            <input type="checkbox" @if($payroll->include_attendance) checked @endif name="include_attendance">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            

                        </div>

                        
                        <div class="kt-portlet__foot" style="text-align: center">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary update-attendance-submit">{{__('confirm')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

    <!--end::Portlet-->

    <div class="modal fade" id="reissue-modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Financial Move')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right update-attendance-form ajax" method="POST" action="{{route('dashboard.financial.store')}}">
                        @csrf
                        <input type="text" value="{{ $payroll->id }}" name="payroll_id" style="display: none;">
                        <div class="kt-portlet__body">
                            
                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <label>{{__('search with name / job number')}}</label>
                                    <div class="spinner spinner-primary spinner-left">
                                        <div class="form-group">
                                            <input name="job_number" id="job_number_search" class="form-control" type="text">
                                        </div>
                                    </div>
                                    
                                    <center>
                                        <span class='hide01'>{{__('employee_name')}}</span>
                                        <span class='hide01 fname_ar'></span>
                                        <span class='hide01 fname_en'></span>
                                    </center>
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <label>{{__('Movement value')}}</label>
                                    <div class="form-group">
                                        <input name="value" class="form-control" type="number">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <label>{{__('description')}}</label>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>


                            <center>
                                <span class='hide02 message_ok'></span>
                            </center>

                            
                        </div>

                        
                        <div class="kt-portlet__foot" style="text-align: center">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary update-attendance-submit">{{__('confirm')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reissue-modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Overtime+')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right update-attendance-form ajax" method="POST" action="{{route('dashboard.overtime.store')}}">
                        @csrf
                        <input type="text" value="{{ $payroll->id }}" name="payroll_id" style="display: none;">
                        <div class="kt-portlet__body">
                            
                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <label>{{__('search with name / job number')}}</label>
                                    <div class="spinner spinner-primary spinner-left">
                                        <div class="form-group">
                                            <input name="job_number" id="job_number_search2" class="form-control" type="text">
                                        </div>
                                    </div>
                                    
                                    <center>
                                        <span class='hide01'>{{__('employee_name')}}</span>
                                        <span class='hide01 fname_ar'></span>
                                        <span class='hide01 fname_en'></span>
                                    </center>
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-lg-6">
                                    <label>{{__('How many more hours?')}}</label>
                                    <div class="form-group">
                                        <input name="hours" class="form-control" type="number">
                                    </div>
                                </div>
                            </div>

                            <center>
                                <span class='hide02 message_ok'></span>
                            </center>

                        </div>

                        
                        <div class="kt-portlet__foot" style="text-align: center">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary update-attendance-submit">{{__('confirm')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')
    <script>
        var payroll_id = {{$payroll->id}};
    </script>
    <script src="{{asset('js/datatables/salaries.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/ajax.form.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function(e) {
            $(".ajax").ajaxForm({

                beforeSend : function(){
                    $(".hide02").hide(0);
                    $(".ajax .fv-plugins-message-container").remove();
                    $(".is-invalid").removeClass("is-invalid");
                    load_button($(".ajax").find('button[type="submit"]'));
                },
                complete: function(data){
                    check_errors(data);
                    close_button();
                }

            });
        });


        
        function check_errors(data){
            if(data.status == 422){
                $(".ajax .error").remove();
                var errors = data.responseJSON.errors;
                const keys = Object.keys(errors);
                keys.forEach((key, index) => {
                    error_message($('input[name="'+key+'"]'), errors[key][0]);
                    error_message($('textarea[name="'+key+'"]'), errors[key][0]);
                });

                $('.fv-plugins-message-container').hide(0).slideDown(400);
            }else if(data.status == 201){
                $('.ajax').trigger("reset");
                $(".message_ok").html("{{ __('message_ok01') }}").fadeIn();
                
            }
        }

        function error_message(ele, mess){
            ele.addClass('is-invalid');
            ele.closest('.form-group').append(`<div class="error invalid-feedback">${mess}</div>`);
        }

        var eleButton = "";
        function load_button(ele){
            eleButton = ele;
            ele.attr('disabled','disabled').addClass('spinner spinner-dark spinner-left');
        }
        function close_button(){
            eleButton.removeAttr('disabled','disabled').removeClass('spinner spinner-white spinner-left');
        }

        </script>
    <script>
        $(function () {
            $('#reissue-btn').click(function () {
                var modal = $("#reissue-modal");
                modal.modal('show');
            });

            $('#reissue-btn2').click(function () {
                var modal = $("#reissue-modal2");
                modal.modal('show');
            });

            $('#reissue-btn3').click(function () {
                var modal = $("#reissue-modal3");
                modal.modal('show');
            });

            $("#job_number_search, #job_number_search2").keyup(function (e) { 
                var job_number = $(this).val();
                
                $.get('/dashboard/search_employee_from_job_number',{job_number},function(ee){
                    $(".hide01").hide(0);
                    if(ee != '' ){
                        $(".fname_ar").html(ee.name_ar+" / "+ee.name_en);
                        $(".hide01").fadeIn();
                    }
                    console.log(ee);
                });
                
            });
        })
    </script>
    <style>
        .message_ok{
            background: #f4ffef;
            padding: 16px;
            margin: 16px;
            border-radius: 4px 0px 0px 22px;
            color: #5867dd;
            border-right: 8px solid;
            font-weight: bold;
            text-shadow: 0 0 transparent;
            font-size: 14px;
        }
        .hide01, .hide02{
            display: none;
        }

    </style>
@endpush
