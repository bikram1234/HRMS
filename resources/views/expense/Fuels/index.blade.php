
@extends('layouts.index')

@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 30px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 30px;
}

.inactive-button:hover{
    background-color:#f5a524;
}

.icon-spacing {
    margin-left: 10px; /* Adjust the value to control the spacing */
    display: inline-block; /* Ensures the span takes up space */
}

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">  
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Expense Fuel</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/Expense Fuel</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense_fuel"><i class="fa fa-plus"></i>Add Expense Fuel</a>
                </div>
                
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Search Filter -->
        <!-- <div class="row filter-row">
            <div class="col-sm-6 col-md-3"> 
                <div class="form-group form-focus select-focus">
                    <select class="select floating"> 
                        <option>-</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                        <option>MR.Kinzang Dorji</option>
                    </select>
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>   
        </div> -->
            <!-- /Search Filter -->             
    <div class="row mt-4">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="container table-responsive">  
                            <table id="example" class="table table-striped custom-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">
                                        <label>
                                            <input type="checkbox" id="selectAllCheckbox">
                                            <span>SI</span>
                                        </label>
                                        </th>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Vehicle No</th>
                                        <th>Vechicl Type</th>
                                        <th>Initial KM</th>
                                        <th>Final KM</th>
                                        <th>Quantity</th>
                                        <th>Mileage</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                @foreach($fuels as $key => $fuel)
                                    <tr>
                                       
                                    <th style="width: 30px;">
                                        <label>
                                            <input type="checkbox" id="selectAllCheckbox">
                                            <span>{{ $key + 1 }}</span>
                                        </label>
                                        </th>
                                    <td>{{ $fuel->employee_name }}</td>
                                    <td>{{ $fuel->date }}</td>
                                    <td>{{ $fuel->location }}</td>
                                    <td>{{ $fuel->vehicle_no }}</td>
                                    <td>{{ $fuel->vehicle_type }}</td>
                                    <td>{{ $fuel->initial_km }}</td>
                                    <td>{{ $fuel->final_km }}</td>
                                    <td>{{ $fuel->quantity }}</td>
                                    <td>{{ $fuel->mileage }}</td>
                                    <td>{{ $fuel->rate }}</td>
                                    <td>{{ $fuel->amount }}</td>
                                    <td>
                                        @if ($fuel->status === 'pending')
                                            <button class="btn btn-warning">Pending</button>
                                        @elseif ($fuel->status === 'approved')
                                            <button class="btn btn-success">Approved</button>
                                        @elseif ($$fuel->status === 'rejected')
                                            <button class="btn btn-danger">Rejected</button>
                                        @endif
                                        </td>
                                        
                                        <td class="text-right">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('fuels.edit', $fuel->id) }}" data-toggle="modal" data-target="#">
                                                <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                            </a>
                                        <span class="icon-spacing"></span>
                                        <form action="{{ route('fuels.destroy', $fuel->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                            <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                                        </form>
                                    </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/Add Expense Fuel -->
    <div id="add_expense_fuel" class="modal custom-modal fade" role="dialog">
            <form action="{{ route('fuels.store') }}" method="POST">
            @csrf
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Expense Fuel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employee Name<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="employee_name" value="{{ Auth::user()->name }}" readonly>
                                    <input class="form-control" type="hidden" name="user_id" value="{{ Auth::user()->id }}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Location<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="location">
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                                    <select  name="vehicle_type" id="vehicleTypeSelect"class="form-select  form-select-md" aria-label="Default select example" style="height:45px" onchange="fetchVehicleData(this.value)">
                                    <option value="" selected>Select a vehicle type</option>
                                        @foreach($vehicle->unique('vehicle_type') as $v)
                                            <option value="{{ $v->vehicle_type }}">{{ $v->vehicle_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Vehicle Number<span class="text-danger">*</span></label>
                                    <select  name="vehicle_no" id="vehicleNumberSelect" onchange="fetchVehicleMileage(this.value)" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                    <option value="" selected>Select a vehicle Number</option>
                                        <!-- Vehicle numbers for the selected type will be dynamically loaded here -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Initial KM<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="initial_km" id="initial_km">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Final KM<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="final_km" id="final_km">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Qty(Ltrs)<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="quantity" id="quantity" >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Mileage<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mileage" id="vehicleMileage" >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Rate<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="rate" id="rate" >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Amount<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="amount" id="amount" >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">Date</label>
                                    <input type="date" name="date" class="form-control" >
                                    @error('date')
                                            <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Upload Attachments(Max 2MB)</label>
                                    <input class="form-control" type="file"  name="attachment" id="attachment">
                                </div>
                            </div> 
                            
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" name="save" class="btn btn-primary">Submit</button>
                    <button type="submit" name="cancel" class="btn btn-secondary" data-dismiss="modal">Submit</button>
                </div>
            </div>
            </form>
        </div> 
        <!-- Add Expense Fuel -->
</div>
<!-- /Page Content -->    
</div> 
<!-- /Page Wrapper -->

                
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#selectAllCheckbox').change(function() {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
});
</script>

<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>



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

@endsection



