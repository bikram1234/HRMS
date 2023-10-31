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
@if (session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
    {{ session('success') }}
</div>
@endif
   
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
                <strong>Vehicle Type</strong>
                <select class="form-select" name="vehicle_type" id="vehicleTypeSelect" onchange="fetchVehicleData(this.value)">
                    <option value="" selected>Select a vehicle type</option>
                    @foreach($vehicle->unique('vehicle_type') as $v)
                        <option value="{{ $v->vehicle_type }}">{{ $v->vehicle_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <strong>Vehicle Number</strong>
                <select class="form-select" name="vehicle_no" id="vehicleNumberSelect" onchange="fetchVehicleMileage(this.value)">
                    <option value="" selected>Select a vehicle number</option>
                    <!-- Vehicle numbers for the selected type will be dynamically loaded here -->
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
         <!-- Upload Attachment -->
         <div class="col-md-6 mt-3">
            <label for="attachment" class="block text-gray-700 text-sm font-bold mb-2">
                {{ __('Upload Attachment (Max 2MB)') }}
            </label>
            <input type="file" name="attachment" id="attachment"
                class="form-input rounded-md shadow-sm mt-1 block w-full">
        </div>
    </div>
   
    <div class="row mt-5 justify-content-center">
        <button type="submit" class="btn btn-info btn-block col-md-4">Submit</button>
    </div>
</form>
    </div>

    <script>
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

<script>
    function fetchVehicleData(selectedType) {
        const vehicleNumbersSelect = document.getElementById('vehicleNumberSelect');
        const vehicleMileageInput = document.getElementById('vehicleMileage');
        
        // Clear previous options
        vehicleNumbersSelect.innerHTML = '<option value="" selected>Select a vehicle number</option>';
        vehicleMileageInput.value = ''; // Clear mileage value

        // Fetch vehicles based on the selected type
        const vehicles = @json($vehicle);

        vehicles.forEach(vehicle => {
            if (vehicle.vehicle_type === selectedType) {
                const option = document.createElement('option');
                option.value = vehicle.vehicle_number;
                option.text = vehicle.vehicle_number;
                vehicleNumbersSelect.appendChild(option);
            }
        });
    }

    function fetchVehicleMileage(selectedNumber) {
        const selectedType = document.getElementById('vehicleTypeSelect').value;
        const vehicles = @json($vehicle);

        vehicles.forEach(vehicle => {
            if (vehicle.vehicle_type === selectedType && vehicle.vehicle_number === selectedNumber) {
                document.getElementById('vehicleMileage').value = vehicle.vehicle_mileage;
            }
        });
    }
</script>

</x-app-layout>




















