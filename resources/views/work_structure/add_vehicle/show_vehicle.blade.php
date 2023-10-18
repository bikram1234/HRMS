@extends('layout')
@section('content')
    <div class="container">
        <h2>Vehicles List</h2>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add Vehicle</a>

        @if(count($vehicles) > 0)
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Vehicle Number</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle Mileage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->vehicle_number }}</td>
                            <td>{{ $vehicle->vehicle_type }}</td>
                            <td>{{ $vehicle->vehicle_mileage }}</td>
                            <td>
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No vehicles found.</p>
        @endif
    </div>
@endsection
