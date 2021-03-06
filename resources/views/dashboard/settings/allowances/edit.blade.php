@extends('layouts.dashboard')
@push('styles')
    <link href="{{asset('assets/css/pages/wizard/wizard-1' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Allowances')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.allowances.index')}}" class="btn btn-secondary">
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
                    {{__('Update Info')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add" data-ktwizard-state="step-first">
                @include('layouts.dashboard.parts.errorSection')
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form action="{{route('dashboard.allowances.update', $allowance->id)}}" method="post" class="kt-form" style="width: 80%" id="">
                    @csrf
                    @method('PUT')
                    <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">

                                                        <div class="form-group row mt-5 mb-5">
                                                            <div class="col-6">

                                                                <label>{{__('Name In Arabic')}} *</label>
                                                                <input name="name_ar"
                                                                       value="{{old('name_ar') ?? $allowance->name_ar}}"
                                                                       class="form-control @error('name_ar') is-invalid @enderror"
                                                                       type="text">

                                                            </div>
                                                            <div class="col-6">

                                                                <label>{{__('Name In English')}} *</label>
                                                                <input name="name_en"
                                                                       value="{{old('name_en') ?? $allowance->name_en}}"
                                                                       class="form-control @error('name_en') is-invalid @enderror"
                                                                       type="text">

                                                            </div>

                                                        </div>
                                                        <div class="form-group row mt-5 mb-5">
                                                            <div class="col-4">

                                                                <label>{{__('Allowance Type')}} *</label>
                                                                <select class="form-control @error('type') is-invalid @enderror kt-selectpicker" data-val="true" name="type" >
                                                                    <option value="" selected>
                                                                        {{__('Choose')}}
                                                                    </option>
                                                                    <option value="1" @if((old('type') ?? $allowance->type) == 1) selected @endif>
                                                                        {{__('Addition')}}
                                                                    </option>
                                                                    <option value="0" @if((old('type') ?? $allowance->type) == 0) selected @endif>
                                                                        {{__('Deduction')}}
                                                                    </option>
                                                                </select>

                                                            </div>

                                                            <div class="col-4">

                                                                <label>{{__('Value In Ryal')}} *</label>
                                                                <input name="value"
                                                                       value="{{old('value') ?? $allowance->value}}"
                                                                       class="form-control @error('value') is-invalid @enderror"
                                                                       type="number">

                                                            </div>

                                                            <div class="col-4">

                                                                <label>{{__('Value In Percentage')}} *</label>
                                                                <input name="percentage"
                                                                       value="{{old('percentage') ?? $allowance->percentage}}"
                                                                       class="form-control @error('percentage') is-invalid @enderror"
                                                                       type="number" >

                                                            </div>

                                             
                                                        </div>

                                                        <div class="form-group row col-6">
                                                            <label
                                                                class="col-6 col-form-label">{{__('Activation in the advance salary')}}</label>
                                                            <div class="col-6">
                                                                <span class="kt-switch kt-switch--icon">
                                                                    <label>
                                                                        <input type="checkbox" @if ($allowance->active_in_advance_salary)
                                                                            checked
                                                                        @endif name="active_in_advance_salary">
                                                                        <span></span>
                                                                    </label>
                                                                </span>
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
                            <button type="submit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto" style="display: block" data-ktwizard-type="action-submit">
                                {{__('confirm')}}
                            </button>
                        </div>

                        <!--end: Form Actions -->
                    </form>

                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>
@endsection

