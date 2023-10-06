<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Transfer Claim') }}
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
       
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
          
            <div class="row">
            <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Employee ID</strong>
                        <input type="text" name="employee_id" class="form-control" placeholder="Employee ID" value="{{ Auth::user()->employee_id }}" readonly>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Designation</strong>
                        <input type="text" name="designation" class="form-control" placeholder="Designation" value="{{ Auth::user()->designation->name }}" readonly>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Department</strong>
                        <input type="text" name="department" class="form-control" placeholder="Department" value="{{ Auth::user()->department->na }}" readonly>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Basic Pay</strong>
                        <input type="text" name="basic_pay" class="form-control" placeholder="Basic Pay" value="{{ Auth::user()->grade->basicPay->amount }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Transfer Claim Type</strong>
                        <select class="form-select" aria-label="Default select example" type="text" name="transfer_claim_type" id="transferClaimTypeSelect">
                            <option selected>Select</option>
                            <option value="Transfer Grant">Transfer Grant</option>
                            <option value="Carriage Charge">Carriage Charge</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Current Location</strong>
                        <input type="text" name="current_location" class="form-control" placeholder="Current Location">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>New Location</strong>
                        <input type="text" name="new_location" class="form-control" placeholder="New Location">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <strong>Claim Amount</strong>
                        <input type="text" name="claim_amount" class="form-control" placeholder="Claim Amount">
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3" id="distanceField" style="display: none;">
                    <div class="form-group">
                        <strong>Distance(KM)</strong>
                        <input type="text" name="distance_km" class="form-control" placeholder="Distance(KM)">
                    </div>
                </div>
           
            <div class="row mt-5 justify-content-center">
                <button type="submit" class="btn btn-info btn-block col-md-4">Submit</button>
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
