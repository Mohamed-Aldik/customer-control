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

    <div class="kt-portlet" >
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Resignation Request')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add" data-ktwizard-state="step-first">
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form action="{{route('dashboard.resignations.store')}}" method="post" class="kt-form" id="kt_contacts_add_form">
                    @csrf
                    <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-portlet__body">
                                                    <div class="row text-center m-3">
                                                        <div class="col-lg-4">
                                                            <label for="kt_select2_1">{{__('Termination reason')}} *</label>
                                                            <select class="form-control selectpicker"
                                                                    name="reason"
                                                                    title="{{__('choose')}}">
                                                                @foreach($reasons as $key => $reason)
                                                                    <option value="{{$key}}">{{__($reason)}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label for="termination_date">{{__('Last Working Date')}} *</label>
                                                            <div class="input-group date">
                                                                <input name="termination_date" type="text" class="form-control datepicker" readonly/>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class=" mt-5 mx-auto" id="spinner">

                                                        </div>
                                                        <div id="info-div" class="col-lg-12  mt-5" style="display: none">
                                                            <div class="kt-section kt-section--first">
                                                                <h3 class="kt-section__title">1. {{__('Employee Information')}}</h3>
                                                                <div class="row text-center">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label >
                                                                                <strong>{{__('Employee Number')}}</strong>
                                                                            </label>
                                                                            <p class="emp_num"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label >
                                                                                <strong>{{__('Employee Name')}}</strong>
                                                                            </label>
                                                                            <p class="emp_name"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <strong>{{__('Joined Date')}}</strong>
                                                                            </label>
                                                                            <p class="emp_joined_date"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="kt-separator kt-separator--space-lg kt-separator--portlet-fit"></div>

                                                            <div class="kt-section">
                                                                <h3 class="kt-section__title">2. {{__('Years Of Service')}}</h3>
                                                                <div class="row text-center">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <strong>{{__('Years')}}</strong>
                                                                            </label>
                                                                            <p class="years"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="Months">
                                                                                <strong>{{__('Months')}}</strong>
                                                                            </label>
                                                                            <p class="months"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>
                                                                                <strong>{{__('Days')}}</strong>
                                                                            </label>
                                                                            <p class="days"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-separator  kt-separator--space-lg kt-separator--portlet-fit"></div>
                                                            <div class="kt-section">
                                                                <h3 class="kt-section__title">3. {{__('Entitlements')}}</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 text-center">
                                                                        <div class="form-group m-form__group row bg-light kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label">
                                                                                {{__('End of service reward')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext service_reward">

                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group m-form__group row kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label">
                                                                                {{__('Available Vacation Balance')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext available_balance">

                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group m-form__group row bg-light kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label">
                                                                                {{__('Benefit')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext benefit">

                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group m-form__group row kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label">
                                                                                {{__('Compensation')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext compensation">

                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group m-form__group row kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label">
                                                                                {{__('Notification Late Deduction')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext notificationLateDeduction">

                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group m-form__group row kt-margin-0">
                                                                            <label class="col-lg-5 col-form-label kt-font-bold">
                                                                                {{__('Total')}}
                                                                            </label>
                                                                            <div class="col-lg-6">
                                                                                <p class="form-control-plaintext kt-font-bold total" >

                                                                                </p>
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
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto" style="display: block" data-ktwizard-type="action-submit">
                                {{__('confirm')}}
                            </div>
                        </div>

                        <!--end: Form Actions -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/pages/reasons.js')}}" type="text/javascript"></script>

    <script>
        $(function (){
            let employee_id = {{auth()->user()->id}};
            let termination_date = $("input[name='termination_date']");
            let reason = $("select[name='reason']");

            // CSRF Token

            $("select[name='reason'], select[name='employee_id']").on('change', function(){
                endServiceReward();
            });

            termination_date.change(function (){
                endServiceReward();
            });

            reason.change(function (){
                if($(this).val() == 1){
                    $("#notification_period").fadeIn()
                }else{
                    $("#notification_period").fadeOut();
                }
            });

            function endServiceReward(){
                if(termination_date.val() !== '' && reason.val() !== ''){
                    $("#spinner").addClass('spinner-grow');
                    $.ajax({
                        method: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "/dashboard/decisions/end_service_reward",
                        data: {
                            "reason": reason.val(),
                            "employee_id": employee_id,
                            "termination_date": termination_date.val(),
                            "notification_period": 'true',
                        },
                        success:function(data){
                            $("#spinner").removeClass('spinner-grow');

                            $(".emp_num").text(data.emp_num);
                            $(".emp_name").text(data.emp_name);
                            $(".emp_joined_date").text(data.emp_joined_date);
                            $(".years").text(data.years);
                            $(".months").text(data.months);
                            $(".days").text(data.days);
                            $(".service_reward").text(data.service_reward.toFixed(2) + ' {{__('SAR')}}');
                            $(".available_balance").text(data.available_balance);
                            $(".benefit").text(data.benefit.toFixed(2) + ' {{__('SAR')}}');
                            $(".compensation").text(data.compensation.toFixed(2) + ' {{__('SAR')}}');
                            $(".notificationLateDeduction").text(data.notificationLateDeduction.toFixed(2) + ' {{__('SAR')}}');
                            $(".total").text(data.total.toFixed(2) + ' {{__('SAR')}}');
                            $("#info-div").fadeIn(2);
                        }
                    });
                }

            }

        });
    </script>
@endpush

