@extends('base')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('/assets/css/cars/update.css') }}">
@endsection

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <div class="wall-background bg-light">
                <h3 class="wall-title">Update vehicle data</h3>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-7">
                            <span class="mt-5"></span>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <form method="post" action="{{ route('update', ['id' => $car->id]) }}">
                                <div class="form-group row justify-content-center">
                                    <label for="vehicleType" class="col-4 col-md-3 col-form-label">Vehicle type</label>
                                    <div class="col-8 col-md-9">
                                        <select name="vehicleType" class="form-control">
                                            @foreach($availableTypes as $type)
                                                @if($car->vehicle_type == $type)
                                                    <option selected value="{{ $type }}">{{ $type }}</option>
                                                @else
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="licensePlate" class="col-4 col-md-3 col-form-label">License plate</label>
                                    <div class="col-8 col-md-9">
                                        <input type="text" class="form-control" name="licensePlate" value="{{ $car->license_plate }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="arrivalTime" class="col-4 col-md-3 col-form-label">Arrival time</label>
                                    <div class="col-8 col-md-9">
                                        <input type="datetime-local" class="form-control" name="arrivalTime" value="{{ str_replace(' ', 'T', $carTime->arrival_time) }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <label for="departureTime" class="col-4 col-md-3 col-form-label">Departure time</label>
                                    <div class="col-8 col-md-9">
                                        <div class="input-group mb-3">
                                            <input type="datetime-local" class="form-control" name="departureTime" value="{{ str_replace(' ', 'T', $carTime->departure_time) }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary" id="buttonDateNow">Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#buttonDateNow').on('click', function () {
            let now = new Date();
            now.setMinutes(now.getMinutes()+1 - now.getTimezoneOffset());
            $('input[name=departureTime]').val(now.toISOString().slice(0,16));
        });
    });
</script>
@endsection
