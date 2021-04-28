@extends('base')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/cars/details.css') }}">
@endsection

@section('body')
<script src="{{ asset('assets/js/cars/details.js') }}"></script>
<script>
    let costAndHours = calculateCurrentCostAndHours('{{ $car->vehicle_type }}', '{{ $carTime->arrival_time }}');
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <div class="wall-background bg-light">
                <h3 class="wall-title">Vehicle details</h3>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-7">
                            <div class="container mt-3">
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Vehicle type:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5>{{ $car->vehicle_type }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">License plate:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5>{{ $car->license_plate }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Arrival time:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5>{{ $carTime->arrival_time }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Departure time:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5>{{ $carTime->departure_time === null ? "Currently parked in" : $carTime->departure_time }}</h5>
                                    </div>
                                </div>
                                @empty($carTime->departure_time)
                                    <small class="text-muted">Based on the current date</small>
                                @endempty
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Hours:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 id="hoursField">
                                            @if($carTime->departure_time)
                                                <script>
                                                    let hours = calculateHours('{{ $carTime->arrival_time }}', '{{ $carTime->departure_time }}');
                                                    $('#hoursField').text(hours);
                                                </script>
                                            @else
                                                <script>
                                                    $('#hoursField').text(Math.ceil(costAndHours['hours']));
                                                </script>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Cost:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 id="costField">
                                            @if($carTime->cost)
                                                {{ $carTime->cost }} $
                                            @else
                                                <script>
                                                    $('#costField').text(costAndHours['cost'] + ' $');
                                                </script>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-5">
                                        <h5 class="font-weight-bold">Created by:</h5>
                                    </div>
                                    <div class="col-7">
                                        <h5>{{ $author->name }} ({{ $author->email }})</h5>
                                    </div>
                                </div>
                                @if($carTime->departure_time)
                                    <a href="{{ route('index') }}" class="btn btn-secondary">Back</a>
                                @else
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
                                    <a href="{{ route('update_view', ['id' => $car->id]) }}" class="btn btn-warning">Update</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
