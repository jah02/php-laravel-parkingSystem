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
    var url_searchMain = '{{ route('searchMain') }}';
    var url_searchHistory = '{{ route('searchHistory') }}';
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
                <span id="tableMain">
                    <div class="container mb-3">
                        <div class="row justify-content-end">
                            <div class="col-8 col-md-5">
                                <small class="text-muted">Search by license plate or arrival time</small>
                                <input type="search" class="form-control" placeholder="Search" id="searchInputMain">
                            </div>
                        </div>
                    </div>
                    <table class="table">
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
                            <tr class="trMain">
                                <td>{{ $vehicle->license_plate }}</td>
                                <td>{{ $vehicle->vehicle_type }}</td>
                                <td>{{ $vehicle->arrival_time }}</td>
                                <td>
                                    <a href="{{ route('details', ['id' => $vehicle->car_id]) }}" class="btn btn-sm btn-info">Details</a>
                                    <a href="{{ route('update_view', ['id' => $vehicle->car_id]) }}" class="btn btn-sm btn-warning mt-1 mt-md-0">Update</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </span>

                <!-- History table -->
                <span id="tableHistory" hidden>
                    <div class="container mb-3">
                        <div class="row justify-content-end">
                            <div class="col-8 col-md-5">
                                <small class="text-muted">Search by license plate or departure/arrival time</small>
                                <input type="search" class="form-control" placeholder="Search" id="searchInputHistory">
                            </div>
                            <div class="col-2 col-md-1 pt-4">
                                <i class="bi bi-arrow-clockwise mr-3" id="reloadHistory"></i>
                            </div>
                        </div>
                    </div>
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
                <i class="bi bi-arrow-up-square-fill fixed-bottom ml-3" id="buttonToTop" hidden></i>

            </div>
        </div>
    </div>
</div>
@endsection
