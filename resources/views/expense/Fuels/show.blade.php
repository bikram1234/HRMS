<x-app-layout>

    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fuel Claim Details') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
    <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="text-center">Fuel Claim Details</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Employee Name:</th>
                        <td>{{ $fuel->employee_name }}</td>
                    
                    <tr>
                        <th>Location:</th>
                        <td>{{ $fuel->location }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $fuel->date }}</td>
                    </tr>
                    <tr>
                        <th>Vehicle No:</th>
                        <td>{{ $fuel->vehicle_no }}</td>
                    </tr>
                    <tr>
                        <th>Vehicle Type:</th>
                        <td>{{ $fuel->vehicle_type }}</td>
                    </tr>
                    <tr>
                        <th>Initial KM:</th>
                        <td>{{ $fuel->initial_km }}</td>
                    </tr>
                    <tr>
                        <th>Final KM:</th>
                        <td>{{ $fuel->final_km }}</td>
                    </tr>
                    <tr>
                        <th>Qty(ltrs):</th>
                        <td>{{ $fuel->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Mileage:</th>
                        <td>{{ $fuel->mileage }}</td>
                    </tr>
                    <tr>
                        <th>Rate:</th>
                        <td>{{ $fuel->rate }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>{{ $fuel->amount }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-center">
                <a class="btn btn-primary" href="{{ route('fuels.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
    </div>

</x-app-layout>
