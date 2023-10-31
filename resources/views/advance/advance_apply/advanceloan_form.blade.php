
@extends('layouts.index')

@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 5px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 5px;
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
                            <h3 class="page-title">Advance/Loan Apply</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/AdvanceLoanManagement/Advance/Loan Apply</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->  
            <div class="row mt-4">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                            @if(session('success'))
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('Add_Advance') }}" enctype="multipart/form-data" id="advanceForm">
                             @csrf
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Advance/Loan Type<span class="text-danger">*</span></label>
                                <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="advanceType" name="advance_type_id">
                                    <option value="none">Select Adance Type</option>
                                    @foreach ($advance_type as $advance)
                                    <option value="{{ $advance->id }}">{{ $advance->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Dynamic Fields Based on Advance Type -->
                        <div id="dynamicFields" class="mt-4">
                            <!-- JavaScript will populate fields here -->
                        </div>
                        <!-- Common Fields -->
                    <div class="col-sm-6 mt-4">
                        <div class="form-group">
                            <label  class="col-form-label" for="upload_file">Upload File</label>
                            <input type="file" name="upload_file" class="form-control-file" accept=".pdf">
                        </div>
                    </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                </form>
            </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const advanceType = document.getElementById('advanceType');
            const dynamicFields = document.getElementById('dynamicFields');

            function generateFields(advanceType) {
                const selectedType = advanceType.options[advanceType.selectedIndex].text;

                dynamicFields.innerHTML = ""; // Clear previous fields

                if (selectedType === 'DSA Advance' || selectedType === 'Advance To Staff') {
                    dynamicFields.innerHTML = `

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label  class="col-form-label" for="mode_of_travel">Mode of Travel</label>
                            <input type="text" name="mode_of_travel" class="form-control" maxlength="255" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="from_location">From Location</label>
                            <input type="text" name="from_location" class="form-control" maxlength="255" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="to_location">To Location</label>
                            <input type="text" name="to_location" class="form-control" maxlength="255" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="from_date">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="to_date">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label" for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    </div>
                </div>
                    `;
                } else if (selectedType === 'Salary Advance') {
                    dynamicFields.innerHTML = `
                        
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="emi_count">EMI Count</label>
                            <input type="number" name="emi_count" class="form-control" min="1" required>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="deduction_period">Deduction Period</label>
                            <input type="date" name="deduction_period" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label  class="col-form-label"for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    </div>
                </div>
                    `;
                } else if (selectedType === 'General Imprest Advance' || selectedType === 'Electricity Imprest Advance') {
                    dynamicFields.innerHTML = `
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    </div>
                </div>
                    `;
                } else if (selectedType === 'SIFA Loan') {
                    dynamicFields.innerHTML = `
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" min="0" required onchange="calculateTotalAndMonthly()">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="interest_rate">Interest Rate</label>
                        <input type="number" name="interest_rate" class="form-control" min="0" required onchange="calculateTotalAndMonthly()">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="total_amount">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" min="0" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="emi_count">EMI Count</label>
                        <input type="number" name="emi_count" class="form-control" min="1" required onchange="calculateTotalAndMonthly()">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="monthly_emi_amount">Monthly EMI Amount</label>
                        <input type="number" name="monthly_emi_amount" class="form-control" min="0" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="deduction_period">Deduction Period</label>
                        <input type="date" name="deduction_period" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label" for="purpose">Purpose</label>
                        <input type="text" name="purpose" class="form-control" maxlength="255" required>
                    </div>
                </div>
            </div>
                `;
                
            }
            else if (selectedType === 'Device EMI') {
                    dynamicFields.innerHTML = `
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label"  for="type">Type</label>
                        <select name="type" class="form-control" id="type" required onchange="updateAmount()">
                            <option value="" selected >Select device</option>
                            @foreach ($device as $item)
                                <option value="{{ $item->id }}" data-amount="{{ $item->amount }}">{{ $item->type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" id="amount" min="0" required readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="interest_rate">Interest Rate</label>
                        <input type="number" name="interest_rate" class="form-control" min="0" required onchange="calculateTotalAndMonthly()">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="total_amount">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" min="0" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="emi_count">EMI Count</label>
                        <input type="number" name="emi_count" class="form-control" min="1" required onchange="calculateTotalAndMonthly()">
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="monthly_emi_amount">Monthly EMI Amount</label>
                        <input type="number" name="monthly_emi_amount" class="form-control" min="0" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="deduction_period">Deduction Period</label>
                        <input type="date" name="deduction_period" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label" for="purpose">Purpose</label>
                        <input type="text" name="purpose" class="form-control" maxlength="255" required>
                    </div>
                </div>
            </div>
                `;
                
            }
        }
        advanceType.addEventListener('change', function() {
            generateFields(this);
        });

        generateFields(advanceType); // Generate fields for the initially selected advance type
    });
   function calculateTotalAndMonthly() {
    const amountField = document.getElementsByName('amount')[0];
    const interestRateField = document.getElementsByName('interest_rate')[0];
    const totalAmountField = document.getElementsByName('total_amount')[0];
    const emiCountField = document.getElementsByName('emi_count')[0]; // Ensure correct field selection
    const monthlyEMIField = document.getElementsByName('monthly_emi_amount')[0];

    const amount = parseFloat(amountField.value);
    const interestRate = interestRateField.value.trim() === '' ? NaN : parseFloat(interestRateField.value);
    const emiCount = parseFloat(emiCountField.value); 

    console.log("amountField value:", amountField.value);
    console.log("interestRateField value:", interestRateField.value);
    console.log("emiCountField value:", emiCountField.value);

    console.log("parsed amount:", amount);
    console.log("parsed interest rate:", interestRate);
    console.log("parsed emiCount:", emiCount);

    if (!isNaN(amount) && !isNaN(interestRate)) {
        const totalAmount = (amount + (interestRate * (amount/100))).toFixed(2);
        totalAmountField.value = totalAmount;

        calculateMonthly(emiCount, totalAmount, monthlyEMIField);
    } else {
        console.error("Invalid values for amount or interestRate");
    }
}


function calculateMonthly(emiCount, totalAmount, monthlyEMIField) {
    console.log("emiCount:", emiCount);
    console.log("totalAmount:", totalAmount);
    console.log("monthlyEMIField:", monthlyEMIField);

    if (!isNaN(emiCount) && !isNaN(totalAmount) && monthlyEMIField) {
        const monthlyEMI = (totalAmount / emiCount).toFixed(2);
        console.log("monthlyEMI:", monthlyEMI);
        monthlyEMIField.value = monthlyEMI;
    } else {
        console.error("Invalid values for emiCount, totalAmount, or monthlyEMIField");
    }
}

function updateAmount() {
        var selectBox = document.getElementById("type");
        var selectedValue = selectBox.options[selectBox.selectedIndex].getAttribute('data-amount');
        document.getElementById("amount").value = selectedValue;
    }


</script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

</div>
<!-- /Page Wrapper -->        
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            const advanceTypeSelect = document.getElementById("advance_type");
            const dsaAdvanceForm = document.getElementById("dsa_advance_form");
            const salaryAdvanceForm = document.getElementById("salary_advance_form");
            const submitButton = document.getElementById("submit_button");

            advanceTypeSelect.addEventListener("change", function() {
                const selectedType = this.value;
                dsaAdvanceForm.style.display = selectedType === "DSA Advance" ? "block" : "none";
                salaryAdvanceForm.style.display = selectedType === "Salary Advance" ? "block" : "none";
            });

            submitButton.addEventListener("click", function() {
                const selectedType = advanceTypeSelect.value;
                if (selectedType === "DSA Advance") {
                    dsaAdvanceForm.querySelector("form").submit();
                } else if (selectedType === "Salary Advance") {
                    salaryAdvanceForm.querySelector("form").submit();
                }
            });
        });
    </script>
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>

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


@endsection



