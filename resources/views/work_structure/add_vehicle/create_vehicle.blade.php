@extends('layout')
@section('content')
    <div class="container">
        <h2>Add Vehicle</h2>

        <form method="POST" action="{{ route('vehicles.store') }}">
            @csrf
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_number">Vehicle Number:</label>
                <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" placeholder="Enter Vehicle Number" required>
            </div>
            </div>
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_type">Vehicle Type:</label>
                <input type="text" name="vehicle_type" id="vehicle_type" class="form-control" placeholder="Enter Vehicle Type" required>
            </div>
            </div>
            <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="vehicle_mileage">Vehicle Mileage:</label>
                <input type="number" name="vehicle_mileage" id="vehicle_mileage" class="form-control" placeholder="Enter Vehicle Mileage" required>
            </div>
            </div>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Add Vehicle</button>
        </form>
    </div>
@endsection
