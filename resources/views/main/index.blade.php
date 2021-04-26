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
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">License plate</th>
                        <th scope="col">Vehicle type</th>
                        <th scope="col">Arrive time</th>
                        @auth <th scope="col">Action</th> @endauth
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parkedVehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->license_plate }}</td>
                        <td>{{ $vehicle->vehicle_type }}</td>
                        <td>{{ $vehicle->arrival_time }}</td>
                        @auth
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Details</a>
                                <a href="#" class="btn btn-sm btn-warning">Update</a>
                            </td>
                        @endauth
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
