<x-app-layout>

    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Fuel Claim') }}
        </h2>
    </x-slot>
    <div class="container justify-content-center">
    <div class="row">
    <div class="col-lg-12 margin-tb mt-3">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('fuels.index') }}"> Back</a>
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
   
<form action="{{ route('fuels.store') }}" method="POST">
    @csrf
  
    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Employee Name</strong>
                <input type="text" name="employee_name" class="form-control" placeholder="Employee ID" value="{{ Auth::user()->name }}" readonly>
                <input type="hidden" name="user_id" class="form-control" placeholder="Employee ID" value="{{ Auth::user()->id }}" readonly>

            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Location</strong>
                <input type="text" name="location" class="form-control" placeholder="Location">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Date</strong>
                <input type="date" name="date" class="form-control" placeholder="Date">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Vehicle No</strong>
                <input type="text" name="vehicle_no" class="form-control" placeholder="Vehicle No">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Vehicle Type</strong>
                <select class="form-select" name="vehicle_type" id="vehicleTypeSelect">
                    <option value="" selected>Select a vehicle type</option>
                    <option value="Creta">Creta</option>
                    <option value="Maruti Ecco">Maruti Ecco</option>
                    <option value="Bolero">Bolero</option>
                    <option value="Santafee">Santafee</option>
                    <option value="Isuzu D Max">Isuzu D Max</option>
                    <option value="Isuzu S Cabin">Isuzu S Cabin</option>
                    <option value="Motorbikes">Motorbikes</option>
                    <option value="i-20 Active">i-20 Active</option>
                    <option value="COW">COW</option>
                    <option value="MUX">MUX</option>
                    <option value="TUV">TUV</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Initial KM</strong>
                <input type="text" name="initial_km" id="initial_km" class="form-control" placeholder="Initial KM">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Final KM</strong>
                <input type="text" name="final_km" id="final_km" class="form-control" placeholder="Final KM">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Qty(ltrs)</strong>
                <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Qty(ltrs)" readonly>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Mileage</strong>
                <input type="text" name="mileage" id="vehicleMileage" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Rate</strong>
                <input type="text" name="rate" id="rate" class="form-control" placeholder="Rate">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Amount</strong>
                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" readonly>
            </div>
        </div>
    </div>
   
    <div class="row mt-5 justify-content-center">
        <button type="submit" class="btn btn-info btn-block col-md-4">Submit</button>
    </div>
</form>
    </div>

    <script>
    const mileageValues = {
        Creta: 12,
        "Maruti Ecco": 8.5,
        Bolero: 8,
        Santafee: 11,
        "Isuzu D Max": 8.5,
        "Isuzu S Cabin": 8.5,
        Motorbikes: 28,
        "i-20 Active": 4,
        COW: 4,
        MUX: 13,
        TUV: 19,
        // Add more vehicle-mileage pairs here
    };

    const vehicleTypeSelect = document.getElementById('vehicleTypeSelect');
    const vehicleMileageInput = document.getElementById('vehicleMileage');
    const initialKmInput = document.getElementById('initial_km');
    const finalKmInput = document.getElementById('final_km');
    const quantityInput = document.getElementById('quantity');
    const rateInput = document.getElementById('rate');
    const amountInput = document.getElementById('amount');

    // Function to calculate and update the Mileage field
    function calculateMileage() {
        const selectedVehicle = vehicleTypeSelect.value;
        const mileage = mileageValues[selectedVehicle] || '';
        vehicleMileageInput.value = mileage;
        calculateQuantity();
    }

    // Function to calculate and update the Quantity field
    function calculateQuantity() {
        const initialKm = parseFloat(initialKmInput.value) || 0;
        const finalKm = parseFloat(finalKmInput.value) || 0;
        const mileage = parseFloat(vehicleMileageInput.value) || 0;

        // Calculate quantity using the formula: (Final KM - Initial KM) / Mileage
        const quantity = (finalKm - initialKm) / mileage;

        // Update the Quantity input field with the calculated quantity
        quantityInput.value = quantity.toFixed(2); // You can adjust the decimal places as needed
        calculateAmount();
    }

    // Function to calculate and update the Amount field
    function calculateAmount() {
        const rate = parseFloat(rateInput.value) || 0;
        const quantity = parseFloat(quantityInput.value) || 0;

        // Calculate amount using the formula: Rate * Quantity
        const amount = rate * quantity;

        // Update the Amount input field with the calculated amount
        amountInput.value = amount.toFixed(2); // You can adjust the decimal places as needed
    }

    // Add event listeners to trigger the calculations
    vehicleTypeSelect.addEventListener('change', calculateMileage);
    initialKmInput.addEventListener('input', calculateQuantity);
    finalKmInput.addEventListener('input', calculateQuantity);
    vehicleMileageInput.addEventListener('input', calculateQuantity);
    rateInput.addEventListener('input', calculateAmount);
    quantityInput.addEventListener('input', calculateAmount);

    // Initial calculation when the page loads
    calculateMileage();
</script>

</x-app-layout>
