@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Requests')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.requests.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon-file-1 kt-font-brand"></i>
                    </span>
                <h3 class="kt-portlet__head-title kt-font-brand">
                    {{__('Details')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">

            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="kt-user-card-v2 employee-card employee-card-small">
                                    <div class="kt-user-card-v2__pic">
                                        <div class="kt-widget__media">
                                            <div class="kt-badge kt-badge--xl kt-badge--success">{{ mb_substr( $employee->name() ,0,2,'utf-8')}}</div>
                                            <div class="text-center kt-font-bold kt-margin-t-5">
                                                {{$employee->job_number}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-user-card-v2__details">
                                        <a class="kt-user-card-v2__name" href="{{route('dashboard.employees.show', $employee)}}">
                                            {{$employee->job_number  . ' - ' . $employee->name()}}
                                        </a>
                                        <span class="kt-user-card-v2__desc">{{$employee->role->name()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group"><label for="Request.CreatedDate"><strong>{{__('Request Date')}}</strong></label><p>
                                    {{$request->created_at->format('Y-m-d')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label for="Request.RequestType"><strong>{{__('Request Type')}}</strong></label><p>{{$request->type()}}</p></div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Request.WorkflowInstance.State"><strong>{{__('Status')}}</strong></label>
                                <p>
                                    <span class="kt-badge {{$request->statusClass()}} kt-badge--inline kt-badge--pill">{{$request->statusTitle()}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="form-group"><label for="Date"><strong>{{__('Request Date')}}</strong></label><p>
                                    {{$request->created_at->format('Y-m-d')}}</p></div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="form-group"><label for="From"><strong>{{__('Reason')}}</strong></label><p>{{$reason}}</p></div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div id="info-div" class="col-lg-12  mt-5" >
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
        @can(['proceed_requests', 'not-company'])
        <div class="kt-portlet__foot mt-0">
            <div class="kt-section">
                <h3 class="kt-section__title">{{__('Take action')}}</h3>
                <div class="kt-section__content kt-section__content--border">
                    <!-- Begin Action Form-->
                    @include('layouts.dashboard.parts.errorSection')
                    <form method="post"   action="{{route('dashboard.requests.take_action', $request)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{__('Action')}}</label>
                                    <select name="status"  class="form-control selectpicker" >
                                        <option value="">{{__('Choose')}}</option>
                                        <option value="1">{{__('Approve')}}</option>
                                        <option value="2">{{__('Disapprove')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{__('Comments')}}</label>
                                    <textarea name="comment" class="form-control" rows="6">{{$request->comment}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="kt-form__acdtions">

                            <button type="submit" class="btn btn-success">{{__('Submit')}}</button>

                            <a href="{{route('dashboard.requests.index')}}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                    <!-- Begin Action Form END-->

                </div>
            </div>

        </div>
        @endcan
    </div>
    <!--Begin::Row-->



@endsection

@push('scripts')
    <script>
        $(function (){
            let employee_id = {{$request->employee_id}};
            let termination_date = '{{$requestable->termination_date}}';
            let reason = {{$requestable->reason}};

            // CSRF Token

            endServiceReward();


            function endServiceReward(){
                $.ajax({
                    method: "get",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/dashboard/decisions/end_service_reward",
                    data: {
                        "reason": reason,
                        "employee_id": employee_id,
                        "termination_date": termination_date,
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

        });
    </script>
@endpush
