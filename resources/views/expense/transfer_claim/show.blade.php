<x-app-layout>

    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer Claim Details') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="text-center">Transfer Claim Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Employee ID:</th>
                                <td>{{ $product->employee_id }}</td>
                            </tr>
                            <tr>
                                <th>Designation:</th>
                                <td>{{ $product->designation }}</td>
                            </tr>
                            <tr>
                                <th>Department:</th>
                                <td>{{ $product->department }}</td>
                            </tr>
                            <tr>
                                <th>Basic Pay:</th>
                                <td>{{ $product->basic_pay }}</td>
                            </tr>
                            <tr>
                                <th>Transfer Claim Type:</th>
                                <td>{{ $product->transfer_claim_type }}</td>
                            </tr>
                            <tr>
                                <th>Current Location:</th>
                                <td>{{ $product->current_location }}</td>
                            </tr>
                            <tr>
                                <th>New Location:</th>
                                <td>{{ $product->new_location }}</td>
                            </tr>
                            <tr>
                                <th>Claim Amount:</th>
                                <td>{{ $product->claim_amount }}</td>
                            </tr>
                            <!--  display Distance(KM) when Transfer Claim Type is carriage charge -->
                            @if ($product->transfer_claim_type === 'Carriage Charge')
                                <tr>
                                    <th>Distance(KM):</th>
                                    <td>{{ $product->distance_km }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
