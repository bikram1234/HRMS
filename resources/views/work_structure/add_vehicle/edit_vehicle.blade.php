@extends('layout')
@section('content')
    <div class="container">
        <h2>Edit Vehicle</h2>

        <form method="POST" action="{{ route('vehicles.update', $vehicle) }}">
            @csrf
            @method('PUT')
            <div class="row">
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_number">Vehicle Number:</label>
                <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" value="{{ $vehicle->vehicle_number }}" required>
            </div>
            </div>
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_type">Vehicle Type:</label>
                <input type="text" name="vehicle_type" id="vehicle_type" class="form-control" value="{{ $vehicle->vehicle_type }}" required>
            </div>
            </div>

            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_mileage">Vehicle Mileage:</label>
                <input type="number" name="vehicle_mileage" id="vehicle_mileage" class="form-control" value="{{ $vehicle->vehicle_mileage }}" required>
            </div>
            </div>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Update Vehicle</button>
        </form>
    </div>
@endsection
