@extends('base')

@section('stylesheets')
    <link href="{{ asset('assets/css/main/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
@endsection

@section('body')
<script src="{{ asset('assets/js/main/index.js') }}"></script>
<script>
    var url_history = '{{ route('history') }}';
    var url_details = '{{ route('details', ['id' => 1]) }}';
    var url_update = '{{ route('update', ['id' => 1]) }}';
    var url_main = '{{ route('main') }}';
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <div class="wall-background bg-light">
                <ul class="nav nav-tabs nav-fill mb-5">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="tabMain">Currently parked vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="tabHistory">History</a>
                    </li>
                </ul>

                <!-- Main table -->
                <table class="table" id="tableMain">
                    <thead>
                    <tr>
                        <th scope="col">License plate</th>
                        <th scope="col">Vehicle type</th>
                        <th scope="col">Arrival time</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody id="tableMainBody">
                    @foreach($parkedVehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->license_plate }}</td>
                        <td>{{ $vehicle->vehicle_type }}</td>
                        <td>{{ $vehicle->arrival_time }}</td>
                        <td>
                            <a href="{{ route('details', ['id' => $vehicle->car_id]) }}" class="btn btn-sm btn-info">Details</a>
                            <a href="{{ route('update_view', ['id' => $vehicle->car_id]) }}" class="btn btn-sm btn-warning">Update</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- History table -->
                <span id="tableHistory" hidden>
                    <i class="bi bi-arrow-clockwise float-right mr-3" id="reloadHistory"></i>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">License plate</th>
                            <th scope="col">Vehicle type</th>
                            <th scope="col">Arrive time</th>
                            <th scope="col">Departure time</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tableHistoryBody"></tbody>
                    </table>
                </span>

                <!-- Loading wheel -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="spinner-border text-primary" role="status" id="loadingWheel" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

                <!-- Error display -->
                <div class="alert alert-danger" id="errorBox" hidden>
                    <p id="errorText"></p>
                </div>

                <!-- Scroll button -->
                <i class="bi bi-arrow-up-square-fill fixed-bottom ml-3" id="buttonToTop"></i>

            </div>
        </div>
    </div>
</div>
@endsection
