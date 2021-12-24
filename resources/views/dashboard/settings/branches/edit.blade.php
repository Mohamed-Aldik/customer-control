@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Branches')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.branches.index')}}" class="btn btn-secondary">
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

        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.branches.update', $branch)}}">
            @method('PUT')
            @csrf
            <div class="kt-portlet__body mx-auto" style="width: 60%">

                <div class="form-group row">
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label>{{__('Arabic Name')}}</label>
                        <input class="form-control @error('name_ar') is-invalid @enderror" type="text" value="{{ old('name_ar') ?? $branch->name_ar }}" id="example-text-input" name="name_ar">
                        @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label>{{__('English Name')}}</label>
                        <input class="form-control @error('name_en') is-invalid @enderror" type="text" value="{{ old('name_en') ?? $branch->name_en}}" id="example-text-input" name="name_en">
                        @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="lat" id="lat" value="{{$branch->lat}}">
                    <input type="hidden" name="lng" id="lng" value="{{$branch->lng}}">

                </div>
                <div class="form-group row">
                    <div id="map" style="height: 500px; width: 100%"></div>
                </div>

            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.branches.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--end::Portlet-->

@endsection

@push('scripts')
    <script>
        let branchMap, infoWindow;

        function initMap() {
            var lat = parseFloat($("#lat").val());
            var lng = parseFloat($("#lng").val());

            var location = { lat: lat, lng: lng };
            branchMap = new google.maps.Map(document.getElementById("map"), {
                center: location,
                zoom: 8,
            });

            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: location,
                map: branchMap,
                title: "Click to zoom",
            });

            infoWindow = new google.maps.InfoWindow();

            const locationButton = document.createElement("button");
            locationButton.textContent = "Pan to Current Location";
            locationButton.classList.add("custom-branchMap-control-button");

            branchMap.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

            locationButton.addEventListener("click", (e) => {
                e.preventDefault();
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            branchMap.setCenter(pos);
                            marker.setPosition(pos);
                            setLatLngInputs(pos);
                        },
                        () => {
                            handleLocationError(true, infoWindow, branchMap.getCenter());
                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            });


            branchMap.addListener("click", (mapsMouseEvent) => {
                var pos = mapsMouseEvent.latLng.toJSON();
                marker.setPosition(pos);
                setLatLngInputs(pos);
            });


            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation
                        ? "Error: The Geolocation service failed."
                        : "Error: Your browser doesn't support geolocation."
                );
                infoWindow.open(branchMap);
            }

            function setLatLngInputs(pos){
                $("#lat").val(pos.lat);
                $("#lng").val(pos.lng);
            }
        }



    </script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4Km6L1iAALvbX18stqmhywN80NN_gGNQ&callback=initMap&libraries=&v=weekly" async></script>
@endpush
