@extends('base')

@section('stylesheets')
    <link href="{{ asset('assets/css/main/index.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <div class="wall-background bg-light">
                <ul class="nav nav-tabs nav-fill mb-5">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Currently parked vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">History</a>
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
                    <tbody>
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
                <table class="table d-none" id="tableHistorical">
                    <thead>
                    <tr>
                        <th scope="col">License plate</th>
                        <th scope="col">Vehicle type</th>
                        <th scope="col">Arrive time</th>
                        <th scope="col">Departure time</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parkedVehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->license_plate }}</td>
                            <td>{{ $vehicle->vehicle_type }}</td>
                            <td>{{ $vehicle->arrival_time }}</td>
                            <td>{{ $vehicle->departure_time }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Details</a>
                                <a href="#" class="btn btn-sm btn-warning">Update</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
