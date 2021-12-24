@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Settings')}}
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
    <!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

        <!--Begin:: App Aside Mobile Toggle-->
        <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
            <i class="la la-close"></i>
        </button>

        <!--End:: App Aside Mobile Toggle-->

        <!--Begin:: App Aside-->
        <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

            <!--begin:: Widgets/Applications/User/Profile4-->
            <div class="kt-portlet kt-portlet--height-fluid-">
                <div class="kt-portlet__body">

                    <!--begin::Widget -->
                    <div class="kt-widget kt-widget--user-profile-4">
                        <div class="kt-widget__head">
                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <a href="#" class="kt-widget__username">
                                        {{__('Payroll Settings')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__body">

                            <a href="{{route('dashboard.settings.payrolls')}}" class="kt-widget__item kt-widget__item--active">
                                {{__('Payrolls')}}
                            </a>
                        </div>
                    </div>

                    <!--end::Widget -->
                </div>
            </div>

            <!--end:: Widgets/Applications/User/Profile4-->

        </div>

        <!--End:: App Aside-->

        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">{{__('Attendance Settings')}}</h3>
                            </div>
                        </div>
                        @include('layouts.dashboard.parts.errorSection')
                        <form class="kt-form kt-form--label-right" action="{{route('dashboard.settings.payrolls')}}" method="post">
                            @csrf
                            <div class="kt-portlet__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        @if(session('success'))
                                            @include('layouts.dashboard.parts.successSection')
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Operations Include')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select class="form-control @error('operations')is-invalid @enderror kt-selectpicker"
                                                        name="operations[]"
                                                        id="operations"
                                                        data-size="5"
                                                        data-live-search="true"
                                                        multiple="multiple"
                                                        title="{{__('Select')}}">
                                                    <option value="deductions" selected>{{__('Deductions')}}</option>
                                                </select>
                                            </div>
                                        </div>
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('The day the payroll is calculated')}}</label>--}}
{{--                                            <div class="col-lg-9 col-xl-6">--}}
{{--                                                <input class="form-control @error('payroll_day') is-invalid @enderror"--}}
{{--                                                       placeholder="" type="number"--}}
{{--                                                       name="payroll_day"--}}
{{--                                                       value="{{ old('payroll_day') ?? setting('payroll_day')}}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Work Days For Manual Payrolls')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control @error('work_days') is-invalid @enderror"
                                                       placeholder="work days" type="number"
                                                       name="work_days"
                                                       value="{{ old('work_days') ?? setting('work_days') ?? 0}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Paid In Advance')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select name="paid_in_advance" class="form-control @error('paid_in_advance') is-invalid @enderror" id="">
                                                    <option @if (setting('paid_in_advance') == 1 ) selected @endif value="1">{{__('1 Month')}}</option>
                                                    <option @if (setting('paid_in_advance') == 2 ) selected @endif value="2">{{__('2 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 3 ) selected @endif value="3">{{__('3 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 4 ) selected @endif value="4">{{__('4 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 5 ) selected @endif value="5">{{__('5 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 6 ) selected @endif value="6">{{__('6 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 7 ) selected @endif value="7">{{__('7 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 8 ) selected @endif value="8">{{__('8 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 9 ) selected @endif value="9">{{__('9 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 10) selected @endif value="10">{{__('10 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 11) selected @endif value="11">{{__('11 Months')}}</option>
                                                    <option @if (setting('paid_in_advance') == 12) selected @endif value="12">{{__('12 Months')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Notice before expiry')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control @error('noti_expiry') is-invalid @enderror"
                                                        type="number"
                                                       name="noti_expiry"
                                                       value="{{ old('noti_expiry') ?? setting('noti_expiry') ?? 30}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Prepaid calculation method')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select name="salary_paid_in_advance" class="form-control @error('salary_paid_in_advance') is-invalid @enderror" id="">
                                                    <option @if (setting('salary_paid_in_advance') == 0 ) selected @endif value="0">راتب اساسي فقط</option>
                                                    <option @if (setting('salary_paid_in_advance') == 1 ) selected @endif value="1">راتب أساسي + بدلات</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Advance salary')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select name="advance_payment" class="form-control @error('advance_payment') is-invalid @enderror" id="">
                                                    <option @if (setting('advance_payment') == "saudi" ) selected @endif value="saudi">{{__('Saudi only')}}</option>
                                                    <option @if (setting('advance_payment') == "nonsaudi" ) selected @endif value="nonsaudi">{{__('Non Saudi')}}</option>
                                                    <option @if (setting('advance_payment') == "all" ) selected @endif value="all">{{__('All')}}</option>
                                                    <option @if (setting('advance_payment') == "close" ) selected @endif value="close">{{__('Close')}}</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Overtime+')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select name="overtime" class="form-control @error('overtime') is-invalid @enderror" id="">
                                                    <option @if (setting('overtime') == "saudi" ) selected @endif value="saudi">{{__('According to the Saudi labor system')}}</option>
                                                    <option @if (setting('overtime') == "basic" ) selected @endif value="basic">{{__('Based on basic only')}}</option>
                                                    <option @if (setting('overtime') == "total" ) selected @endif value="total">{{__('Based on total only')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('Allow vacation balance to be exceeded')}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <select name="vacation_exceeded" class="form-control id="">
                                                    <option value="0">{{__('disable')}}</option>
                                                    <option @if (setting('vacation_exceeded') == 1 ) selected @endif value="1">{{__('enable')}}</option>
                                                </select>
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
                                            <button type="submit" class="btn btn-success">{{__('confirm')}}</button>&nbsp;
                                            <a href="{{route('dashboard.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--End:: App Content-->
    </div>

    <!--End::App-->





    <!--end::Portlet-->
@endsection

@push('scripts')
    <script>
        $(function (){
            $('.start_time').timepicker({
                defaultTime: '9:30:00 AM',
                minuteStep: 1,
                showSeconds: false,
                showMeridian: true,
            });
            $('.end_time').timepicker({
                defaultTime: '6:30:00 AM',
                minuteStep: 1,
                showSeconds: false,
                showMeridian: true,
            });
            $('.overtime').timepicker({
                minuteStep: 1,
                defaultTime: '0:00:00',
                showSeconds: true,
                showMeridian: false,
                snapToStep: true
            });
        });
    </script>
@endpush