<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transfer Claim') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-lg-12 margin-tb mt-3">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Employee ID</strong>
                        <input type="text" name="employee_id" value="{{ $product->employee_id }}" class="form-control" placeholder="Employee ID">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Designation</strong>
                        <input type="text" name="designation" value="{{ $product->designation }}" class="form-control" placeholder="Designation">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Department</strong>
                        <input type="text" name="department" value="{{ $product->department }}" class="form-control" placeholder="Department">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Basic Pay</strong>
                        <input type="text" name="basic_pay" value="{{ $product->basic_pay }}" class="form-control" placeholder="Basic Pay">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Transfer Claim Type</strong>
                        <select class="form-select" aria-label="Default select example" type="text" name="transfer_claim_type" id="transferClaimTypeSelect">
                        <!-- If $product->transfer_claim_type 'Transfer Grant' is true (? represents is true) it displays the selected field (pre-selected in a dropdown). Otherwise, it leaves it unselected. -->
                            <option value="Transfer Grant" {{ $product->transfer_claim_type === 'Transfer Grant' ? 'selected' : '' }}>Transfer Grant</option>
                            <option value="Carriage Charge" {{ $product->transfer_claim_type === 'Carriage Charge' ? 'selected' : '' }}>Carriage Charge</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Current Location</strong>
                        <input type="text" name="current_location" value="{{ $product->current_location }}" class="form-control" placeholder="Current Location">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>New Location</strong>
                        <input type="text" name="new_location" value="{{ $product->new_location }}" class="form-control" placeholder="New Location">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Claim Amount</strong>
                        <input type="text" name="claim_amount" value="{{ $product->claim_amount }}" class="form-control" placeholder="Claim Amount">
                    </div>
                </div>
            </div>

            <!-- when transfer_claim_type is 'Carriage Charge', the element associated with the 'Distance(KM)' is set to be visible (display: block;), and when transfer_claim_type is anything else, that element is hidden (display: none;). This allows you to dynamically show or hide a form field based on the selected transfer claim type. -->
            <div class="col-md-6 mt-3" id="distanceField" style="{{ $product->transfer_claim_type === 'Carriage Charge' ? 'display: block;' : 'display: none;' }}">
                <div class="form-group">
                    <strong>Distance(KM)</strong>
                    <input type="text" name="distance_km" value="{{ $product->distance_km }}" class="form-control" placeholder="Distance(KM)">
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                <button type="submit" class="btn btn-primary col-md-4">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const transferClaimTypeSelect = document.getElementById('transferClaimTypeSelect');
        const distanceField = document.getElementById('distanceField');

        // Function to show/hide the Distance input field based on Transfer Claim Type
        function toggleDistanceField() {
            if (transferClaimTypeSelect.value === 'Carriage Charge') {
                distanceField.style.display = 'block';
            } else {
                distanceField.style.display = 'none';
            }
        }

        // Add event listener to the Transfer Claim Type dropdown
        transferClaimTypeSelect.addEventListener('change', toggleDistanceField);

        // Initial check when the page loads
        toggleDistanceField();
    </script>
</x-app-layout>
