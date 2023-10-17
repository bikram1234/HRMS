
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
                    <h3 class="page-title">DSA Claim/Settlement</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/DSA Claim Settlement</li>
                    </ul>
                </div>
            </div>
        </div> 
       <!-- Add DSA Settlement -->
					<div class="modal-content">
						<div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" action="{{ route('calculate-dsa-settlement') }}" enctype="multipart/form-data">
                                        @csrf
                                        @if(session('success'))
                                        <div class="bg-gray-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                                        <!-- DSA Settlement with advance -->
                                            <div class="row" id="dsa_settlement_fields_with_advance">
                                                <!-- <div class="col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Employee Name<span class="text-danger">*</span></label>
                                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                        <option value="0">Laptop Rent</option>
                                                        <option value="1">Rent</option>
                                                        <option value="2">Sales & Promations Exp</option>
                                                        <option value="3">SIFA Benefits</option>
                                                        <option value="3">Other</option>
                                                        <option value="3">Expense Fuel</option>
                                                        <option value="3">Transfer Claim</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="advance_number">Select Advance No<span class="text-danger">*</span></label>
                                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="advance_number" id="advance_number">
                                                        @foreach($userAdvances as $advanceId => $advanceNo)
                                                        <option value="{{ $advanceNo}}"  data-amount="{{ $advanceAmounts[$advanceId] }}">{{ $advanceNo}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="advance_amount_with_advance">Advance Amount</label>
                                                        <input class="form-control" type="number" name="advance_amount_with_advance" id="advance_amount_with_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="total_amount_adjusted_with_advance" >Total Amount Adjusted</label>
                                                        <input class="form-control" type="number" name="total_amount_adjusted_with_advance" id="total_amount_adjusted_with_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="net_payable_amount_with_advance">Net Payable Amount</label>
                                                        <input class="form-control" type="number"  name="net_payable_amount_with_advance" id="net_payable_amount_with_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="balance_amount_with_advance">Balance Amount</label>
                                                        <input class="form-control" type="number"  name="balance_amount_with_advance" id="balance_amount_with_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="upload_file_with_advance">Upload PDF</label>
                                                        <input  class="form-control" type="file" name="upload_file_with_advance" id="upload_file_with_advance" accept=".pdf">
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- DSA Settlement with advance -->

                                    <!-- DSA Settlement without advance -->
                                            <!-- <div class="row" id="dsa_settlement_fields_without_advance">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Employee Name<span class="text-danger">*</span></label>
                                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                        <option value="0">Laptop Rent</option>
                                                        <option value="1">Rent</option>
                                                        <option value="2">Sales & Promations Exp</option>
                                                        <option value="3">SIFA Benefits</option>
                                                        <option value="3">Other</option>
                                                        <option value="3">Expense Fuel</option>
                                                        <option value="3">Transfer Claim</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="advance_amount_without_advance">Advance Amount</label>
                                                        <input class="form-control" type="number" name="advance_amount_without_advance" id="advance_amount_without_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="total_amount_adjusted_without_advance" >Total Amount Adjusted</label>
                                                        <input class="form-control" type="number" name="total_amount_adjusted_without_advance" id="total_amount_adjusted_without_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="net_payable_amount_without_advance">Net Payable Amount</label>
                                                        <input class="form-control" type="number"  name="net_payable_amount_without_advance" id="net_payable_amount_without_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="balance_amount_without_advance">Balance Amount</label>
                                                        <input class="form-control" type="number"  name="balance_amount_without_advance" id="balance_amount_without_advance">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="upload_file_without_advance">Upload PDF</label>
                                                        <input  class="form-control" type="file" name="upload_file_without_advance" id="upload_file_without_advance" accept=".pdf">
                                                    </div>
                                                </div>
                                         
                                        </div>
                                    <!-- DSA settlement without advance -->
                                            <!-- Tabel -->
                                                <div class="row mt-5">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="manual_settlement_container" class="table table-hover table-white manual-settlement" >
                                                                <tr>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label  for="manual_from_date[]">From Date</label>
                                                                        <input class="form-control datetimepicker" type="date" style="min-width:150px" name="manual_from_date[]" id="manual_from_date[]" required>
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                    <label for="manual_from_location[]">From Location</label>
                                                                        <input class="form-control" type="text" style="min-width:150px" name="manual_from_location[]" id="manual_from_location[]" required>
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="manual_to_date[]">To Date</label>
              
                                                                        <input class="form-control datetimepicker" type="date" style="min-width:150px" name="manual_to_date[]" id="manual_to_date[]" required  >
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="manual_to_location[]">To Location</label>
                                                                        <input class="form-control" type="text" style="min-width:150px"  name="manual_to_location[]" id="manual_to_location[]" required>
                                                                    </td>
                                                                    
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="ta">TA (Travel Allowance)</label>
                                                                        <input class="form-control" type="text" style="min-width:100px" name="manual_ta[]" id="manual_ta[]" required>
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="da">DA (Daily Allowance)</label>
                                                                        <input class="form-control" style="width:100px" type="text" name="da" id="da" value="{{ $daAmountFromBackend }}">
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="total_amount">Total Amount</label>
                                                                        <input class="form-control" style="width:150px" type="number" name="manual_total_amount[]" id="total_amount_manual" required>
                                                                    </td>
                                                                    <td class="dsa-settlement-no-advance">
                                                                        <label for="remark">Remarks</label>
                                                                        <input class="form-control"  style="width:120px" type="text" name="manual_remark[]" id="remark" required>
                                                                    </td>
                                                                    <td>
                                                                        <div class="mb-4">
                                                                            <a type="button" class="text-success font-18" id="addManualSettlementButton" ><i class="fa fa-plus"></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>					
                                                    </div>
                                                </div>
                                            <!-- End of Table -->
                                            <div class="modal-footer justify-content-start mt-3">
                                                    <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                                    &nbsp;  &nbsp;   &nbsp;
                                                    <button type="submit" name="cancel" class="btn btn-primary">Reset</button>
                                            </div> 
							        </form>
						        </div>
					        </div>
                        </div>
			        </div>
            <!-- Add DSA Settlement --> 
    </div>
    <!-- /Page Content -->
</div>
<!-- Page Wrapper -->

             
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const advanceNumberSelect = document.getElementById('advance_number');
            const taInputs = document.querySelectorAll('input[name^="manual_ta"]');
            const daInput = document.getElementById('da');
            const totalAmountManualInput = document.getElementById('total_amount_manual');
            const advanceAmountWithAdvanceInput = document.getElementById('advance_amount_with_advance');
            const totalAmountAdjustedWithAdvanceInput = document.getElementById('total_amount_adjusted_with_advance');
            const netPayableAmountWithAdvanceInput = document.getElementById('net_payable_amount_with_advance');
            const balanceAmountWithAdvanceInput = document.getElementById('balance_amount_with_advance');
            const advanceAmountWithoutAdvanceInput = document.getElementById('advance_amount_without_advance');
            const totalAmountAdjustedWithoutAdvanceInput = document.getElementById('total_amount_adjusted_without_advance');
            const netPayableAmountWithoutAdvanceInput = document.getElementById('net_payable_amount_without_advance');
            const balanceAmountWithoutAdvanceInput = document.getElementById('balance_amount_without_advance');
            const addManualSettlementButton = document.getElementById('add_manual_settlement');
            const fieldsWithAdvance = document.getElementById('dsa_settlement_fields_with_advance');
            const fieldsWithoutAdvance = document.getElementById('dsa_settlement_fields_without_advance');
            const manualSettlementContainer = document.getElementById('manual_settlement_container');
            const manualSettlementTemplate = document.querySelector('.manual-settlement');
            let manualSettlementIndex = 0;
        
            function updateManualTotalAmount() {
                let totalManualAmount = 0;
                taInputs.forEach((taInput) => {
                    const taAmount = parseFloat(taInput.value) || 0;
                    totalManualAmount += taAmount;
                });
        
                const daAmount = parseFloat(daInput.value) || 0;
        
                // Get the values of from_date and to_date
                const fromDateValue = document.getElementById('manual_from_date[]').value;
                const toDateValue = document.getElementById('manual_to_date[]').value;
        
                // Parse the date values using JavaScript Date
                const fromDate = new Date(fromDateValue);
                const toDate = new Date(toDateValue);
        
                // Calculate the total days difference
                const timeDifference = toDate.getTime() - fromDate.getTime();
                const totalDays = Math.floor(timeDifference / (1000 * 3600 * 24)) + 1;
        
                // Calculate the total amount using the formula
                const totalAmount = (daAmount * totalDays) + totalManualAmount;

        
                // Update the total amount input field with the calculated value
                totalAmountManualInput.value = totalAmount.toFixed(2);
        
                // Calculate the sum of all indices of the "manual_total_amount" array
                const sumOfAllIndices = Array.from(document.getElementsByName('manual_total_amount[]'))
                .map(input => parseFloat(input.value) || 0)
                .reduce((accumulator, currentValue) => accumulator + currentValue, 0);
        
                // Insert the sum into the specified fields
                totalAmountAdjustedWithoutAdvanceInput.value = sumOfAllIndices.toFixed(2);
                netPayableAmountWithoutAdvanceInput.value = sumOfAllIndices.toFixed(2);
        
        
                if (advanceNumberSelect.value === "") {
                    // If no advance number is selected, hide "with advance" fields and show "without advance" fields
                    fieldsWithAdvance.style.display = 'none';
                    fieldsWithoutAdvance.style.display = 'block';
                    
        
                    // Set values for "without advance" fields
                    advanceAmountWithoutAdvanceInput.value = '0';
                    totalAmountAdjustedWithoutAdvanceInput.value = sumOfAllIndices.toFixed(2);
                    netPayableAmountWithoutAdvanceInput.value = sumOfAllIndices.toFixed(2);
                    balanceAmountWithoutAdvanceInput.value = '0';
        
                    // Enable the "Add Manual Settlement" button
                    //addManualSettlementButton.disabled = false;
                } else {
                    // If an advance number is selected, hide "without advance" fields and show "with advance" fields
                    fieldsWithAdvance.style.display = 'block';
                    fieldsWithoutAdvance.style.display = 'none';
        
                    // Clear the values of "without advance" fields
                    advanceAmountWithoutAdvanceInput.value = null;
                    totalAmountAdjustedWithoutAdvanceInput.value = null;
                    netPayableAmountWithoutAdvanceInput.value = null;
                    balanceAmountWithoutAdvanceInput.value = null;
        
                    // Disable the "Add Manual Settlement" button when an advance number is selected
                   // addManualSettlementButton.disabled = true;
                }
            }
            
            function updateWithAdvanceFields() {
            if (advanceNumberSelect.value !== "") {
                fieldsWithAdvance.style.display = 'block';
                manualSettlementContainer.style.display = 'none'; // Hide the manual settlement container
                  // Remove the 'required' attribute from the fields when an advance number is selected
                const requiredFields = manualSettlementContainer.querySelectorAll('[required]');
                requiredFields.forEach(field => field.removeAttribute('required'));
                // If an advance number is selected, update "with advance" fields
                const selectedOption = advanceNumberSelect.options[advanceNumberSelect.selectedIndex];
                const advanceAmount = parseFloat(selectedOption.dataset.amount) || 0;
                console.log("Advance Amount:", advanceAmount);
        
                advanceAmountWithAdvanceInput.value = advanceAmount.toFixed(2);
                totalAmountAdjustedWithAdvanceInput.value = advanceAmount.toFixed(2);
                netPayableAmountWithAdvanceInput.value = advanceAmount.toFixed(2);
                balanceAmountWithAdvanceInput.value = '';
            } else {
                fieldsWithAdvance.style.display = 'none';
                manualSettlementContainer.style.display = 'block'; // Show the manual settlement container
                 // Add the 'required' attribute to the fields when no advance number is selected
                const requiredFields = manualSettlementContainer.querySelectorAll('.dsa-settlement-no-advance input');
                requiredFields.forEach(field => field.setAttribute('required', 'required'));
        
                // If no advance number is selected, you can clear or set default values in these fields
                advanceAmountWithAdvanceInput.value = '';
                totalAmountAdjustedWithAdvanceInput.value = '';
                netPayableAmountWithAdvanceInput.value = '';
                balanceAmountWithAdvanceInput.value = '';
        
                console.log("updateWithAdvanceFields called"); // Debugging line
        
            }
        }
        
            taInputs.forEach((taInput) => {
                taInput.addEventListener('input', function () {
                    updateManualTotalAmount();
                    updateWithAdvanceFields();
                });
            });
            advanceNumberSelect.addEventListener('change', function () {
                updateWithAdvanceFields();
                updateManualTotalAmount();
            });
        
            // Initialize the calculation
            updateManualTotalAmount();
            updateWithAdvanceFields();
        });
        
    </script> 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const manualSettlementContainer = document.getElementById('manual_settlement_container');
        let originalFromDateInput = document.querySelector('input[name="manual_from_date[]"]');
        let originalToDateInput = document.querySelector('input[name="manual_to_date[]"]');

        // Add change event listener for date fields in cloned rows
        manualSettlementContainer.addEventListener('change', function (event) {
            // Update the original date inputs
            originalFromDateInput = document.querySelector('input[name="manual_from_date[]"]');
            originalToDateInput = document.querySelector('input[name="manual_to_date[]"]');

            // Check if any cloned row has dates matching the original dates
            const clonedRows = manualSettlementContainer.querySelectorAll('tr:not(:first-child)');
            for (let i = 0; i < clonedRows.length; i++) {
                const clonedFromDateInput = clonedRows[i].querySelector('input[name="manual_from_date[]"]');
                const clonedToDateInput = clonedRows[i].querySelector('input[name="manual_to_date[]"]');
                if (
                    originalFromDateInput.value === clonedFromDateInput.value ||
                    originalToDateInput.value === clonedToDateInput.value
                ) {
                    alert("Original dates cannot be the same as cloned dates!");
                    originalFromDateInput.value = ''; // Clear the original 'From Date' input value
                    originalToDateInput.value = '';   // Clear the original 'To Date' input value
                    break; // Stop checking once a match is found
                }
            }
        });

        const addManualSettlementButton = document.getElementById('addManualSettlementButton');

        addManualSettlementButton.addEventListener('click', function () {
            const originalRow = manualSettlementContainer.querySelector('tr:first-child');

            // Check if any of the original fields are empty
            const originalInputs = originalRow.querySelectorAll('input');
            let isOriginalEmpty = false;
            originalInputs.forEach((originalInput) => {
                if (originalInput.value.trim() === '') {
                    isOriginalEmpty = true;
                }
            });

            if (isOriginalEmpty) {
                alert("Please fill in all original fields before adding a manual settlement.");
            } else {
                // Check if From Date is greater than or equal to To Date
                if (originalFromDateInput.value > originalToDateInput.value) {                   
                     alert("From Date must be greater than or equal to To Date.");
                    return;
                }

                const newRow = originalRow.cloneNode(true);

                // Copy values from the original fields to the cloned fields
                const clonedInputs = newRow.querySelectorAll('input');
                originalInputs.forEach((originalInput, index) => {
                    clonedInputs[index].value = originalInput.value;
                    // Clear the value in the original field except for the DA field
                    if (originalInput.id !== 'da') {
                        originalInput.value = '';
                    }
                    // Set the cloned input fields as readonly
                    clonedInputs[index].readOnly = true;
                });

                // Append the cloned row to the table
                manualSettlementContainer.appendChild(newRow);
            }
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
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>
<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>


@endsection



