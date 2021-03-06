@extends('layouts.dashboard')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{__('Violations')}}
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="#" class="">
            </a>
            <a href="{{route('dashboard.violations.index')}}" class="btn btn-secondary">
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
                {{__('New Violation')}}
            </h3>
        </div>
    </div>
    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.violations.store')}}">
        @csrf
        <div class="kt-portlet__body">
            <div class="form-group row">
                <label for="example-text-input"
                    class="col-form-label col-lg-3 col-sm-12">{{__('Reason In Arabic')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('reason_in_arabic') is-invalid @enderror" type="text"
                        value="{{ old('reason_in_arabic') }}" id="example-text-input" name="reason_in_arabic">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input"
                    class="col-form-label col-lg-3 col-sm-12">{{__('Reason In English')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('reason_in_english') is-invalid @enderror" type="text"
                        value="{{ old('reason_in_english') }}" id="example-text-input" name="reason_in_english">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('First Panel')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('panel1') is-invalid @enderror" type="text"
                        value="{{ old('panel1') }}" id="example-text-input" name="panel1">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Second Panel')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('panel2') is-invalid @enderror" type="text"
                        value="{{ old('panel2') }}" id="example-text-input" name="panel2">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Third Panel')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('panel3') is-invalid @enderror" type="text"
                        value="{{ old('panel3') }}" id="example-text-input" name="panel3">
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Fourth Panel')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <input class="form-control @error('panel4') is-invalid @enderror" type="text"
                        value="{{ old('panel4') }}" id="example-text-input" name="panel4">
                </div>
            </div>


            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Other Panel')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <select name="panel5" class="form-control @error('panel5') is-invalid @enderror">
                        <option value="1">???????? ?????? ??????</option>
                        <option value="2">???????? ???????? ??????</option>
                        <option value="3">???????? ???????? ??????</option>
                        <option value="4">???????? ???????? ??????</option>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Addition To')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <select name="addition_to"
                        class="form-control @error('addition_to')is-invalid @enderror kt-selectpicker"
                        title="{{__('There is no addition')}}">
                        <option value="">{{__('There is no addition')}}</option>
                        <option value="minutes_deduc" @if(old('addition_to')=="minutes_deduc" ) selected @endif>
                            {{__('Determine the late minutes')}}</option>
                        <option value="leave_days" @if(old('addition_to')=="leave_days" ) selected @endif>
                            {{__('Discounting the period of leaving work')}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="example-text-input"
                    class="col-form-label col-lg-3 col-sm-12">{{__('Message_violation_ar')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <textarea name="message_ar" required style="min-height: 100px;"
                        class="form-control @error('message')is-invalid @enderror">{{ old('message_ar') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="example-text-input"
                    class="col-form-label col-lg-3 col-sm-12">{{__('Message_violation_en')}}</label>
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <textarea name="message_en" required style="min-height: 100px;"
                        class="form-control @error('message')is-invalid @enderror">{{ old('message_en') }}</textarea>
                </div>
            </div>


        </div>
        <div class="kt-portlet__foot" style="text-align: center">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                        <a href="{{route('dashboard.violations.index')}}" class="btn btn-secondary">{{__('back')}}</a>
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
<script>
    $(function (){
            $(".kt-selectpicker").selectpicker();
        });
</script>
@endpush