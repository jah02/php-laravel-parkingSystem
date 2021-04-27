@extends('base')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/cars/add.css') }}"
@endsection

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <div class="wall-background bg-light">
                <h3 class="wall-title">Add new vehicle</h3>
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
                            <form method="post" action="{{ route('add_car') }}">
                                <div class="form-group row justify-content-center">
                                    <label for="vehicleType" class="col-4 col-md-3 col-form-label">Vehicle type</label>
                                    <div class="col-8 col-md-9">
                                        <select name="vehicleType" class="form-control">
                                            @foreach($availableTypes as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="licensePlate" class="col-4 col-md-3 col-form-label">License plate</label>
                                    <div class="col-8 col-md-9">
                                        <input type="text" class="form-control" name="licensePlate">
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <label for="arrivalTime" class="col-4 col-md-3 col-form-label">Arrival time</label>
                                    <div class="col-8 col-md-9">
                                        <input type="datetime-local" class="form-control" name="arrivalTime">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
                                <button type="submit" class="btn btn-success">Create</button>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
