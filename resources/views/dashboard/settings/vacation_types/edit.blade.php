@extends('layouts.dashboard')
@push('styles')
<link href="{{asset('assets/css/pages/wizard/wizard-1' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet"
    type="text/css" />
@endpush

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                {{__('Vacation Types')}}
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="#" class="">
            </a>
            <a href="{{route('dashboard.vacation_types.index')}}" class="btn btn-secondary">
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
                {{__('Update Info')}}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add"
            data-ktwizard-state="step-first">
            @include('layouts.dashboard.parts.errorSection')
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <!--begin: Form Wizard Form-->
                <form action="{{route('dashboard.vacation_types.update', $vacationType->id)}}" method="post"
                    class="kt-form" style="width: 80%" id="">
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
                                                        <div class="col-3">
                                                            <label>{{__('Name In Arabic')}} *</label>
                                                            <input name="name_ar"
                                                                value="{{old('name_ar') ?? $vacationType->name_ar}}"
                                                                class="form-control @error('name_ar') is-invalid @enderror"
                                                                type="text">

                                                        </div>
                                                        <div class="col-3">
                                                            <label>{{__('Name In English')}} *</label>
                                                            <input name="name_en"
                                                                value="{{old('name_en') ?? $vacationType->name_en}}"
                                                                class="form-control @error('name_en') is-invalid @enderror"
                                                                type="text">

                                                        </div>
                                                        <div class="col-3">
                                                            <label>{{__('lowest number')}} *</label>
                                                            <input name="min_num"
                                                                value="{{old('min_num') ?? $vacationType->min_num}}"
                                                                class="form-control @error('min_num') is-invalid @enderror"
                                                                min="0" type="number">
                                                        </div>
                                                        <div class="col-3">
                                                            <label>{{__('Maximum number')}} *</label>
                                                            <input name="max_num"
                                                                value="{{old('max_num') ?? $vacationType->max_num}}"
                                                                class="form-control @error('max_num') is-invalid @enderror"
                                                                min="0" type="number">
                                                        </div>

                                                    </div>

                                                    @can('must_be_admin')
                                                    <div class="row">
                                                        <label>{{__('General')}}</label>
                                                        <div class="col-6">
                                                            <span class="kt-switch kt-switch--icon">
                                                                <label>
                                                                    <input type="checkbox" @if ($vacationType->type ==
                                                                    'general')
                                                                    checked
                                                                    @endif value="general" name="type">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endcan

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
                        <button type="submit"
                            class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto"
                            style="display: block" data-ktwizard-type="action-submit">
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