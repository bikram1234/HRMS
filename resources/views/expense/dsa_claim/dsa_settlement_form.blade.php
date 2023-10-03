

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DSA Settlement Form') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
    <form method="POST" action="{{ route('calculate-dsa-settlement') }}" enctype="multipart/form-data">
        @csrf
        @if(session('success'))
        <div class="bg-gray-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="mb-4">
            <label for="advance_number" class="block text-sm font-medium text-gray-700">Select Advance Number:</label>
            <select name="advance_number" id="advance_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @foreach($userAdvances as $advanceId => $advanceNo)
                <option value="{{ $advanceNo }}" data-amount="{{ $advanceAmounts[$advanceId] }}">{{ $advanceNo }}</option>
                @endforeach
            </select>
        </div>

        <div id="dsa_settlement_fields_with_advance">
            <div class="mb-4">
                <label for="advance_amount_with_advance" class="block text-sm font-medium text-gray-700">Advance Amount:</label>
                <input type="text" name="advance_amount_with_advance" id="advance_amount_with_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="total_amount_adjusted_with_advance" class="block text-sm font-medium text-gray-700">Total Amount Adjusted:</label>
                <input type="text" name="total_amount_adjusted_with_advance" id="total_amount_adjusted_with_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="net_payable_amount_with_advance" class="block text-sm font-medium text-gray-700">Net Payable Amount:</label>
                <input type="text" name="net_payable_amount_with_advance" id="net_payable_amount_with_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="balance_amount_with_advance" class="block text-sm font-medium text-gray-700">Balance Amount:</label>
                <input type="text" name="balance_amount_with_advance" id="balance_amount_with_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="upload_file_with_advance" class="block text-sm font-medium text-gray-700">Upload PDF:</label>
                <input type="file" name="upload_file_with_advance" id="upload_file_with_advance" accept=".pdf" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>

        <div id="dsa_settlement_fields_without_advance" style="display: none;">
            <div class="mb-4">
                <label for="advance_amount_without_advance" class="block text-sm font-medium text-gray-700">Advance Amount:</label>
                <input type="text" name="advance_amount_without_advance" id="advance_amount_without_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="total_amount_adjusted_without_advance" class="block text-sm font-medium text-gray-700">Total Amount Adjusted:</label>
                <input type="text" name="total_amount_adjusted_without_advance" id="total_amount_adjusted_without_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="net_payable_amount_without_advance" class="block text-sm font-medium text-gray-700">Net Payable Amount:</label>
                <input type="text" name="net_payable_amount_without_advance" id="net_payable_amount_without_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="balance_amount_without_advance" class="block text-sm font-medium text-gray-700">Balance Amount:</label>
                <input type="text" name="balance_amount_without_advance" id="balance_amount_without_advance" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="upload_file_without_advance" class="block text-sm font-medium text-gray-700">Upload PDF:</label>
                <input type="file" name="upload_file_without_advance" id="upload_file_without_advance" accept=".pdf" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>

        <table id="manual_settlement_container" class="manual-settlement">
            <tr>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="manual_from_date[]" class="block text-sm font-medium text-gray-700">From Date:</label>
                    <input type="date" name="manual_from_date[]" id="manual_from_date[]" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="manual_from_location[]" class="block text-sm font-medium text-gray-700">From Location:</label>
                    <input type="text" name="manual_from_location[]" id="manual_from_location[]" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="manual_to_date[]" class="block text-sm font-medium text-gray-700">To Date:</label>
                    <input type="date" name="manual_to_date[]" id="manual_to_date[]" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="manual_to_location[]" class="block text-sm font-medium text-gray-700">To Location:</label>
                    <input type="text" name="manual_to_location[]" id="manual_to_location[]" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
          
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="ta" class="block text-sm font-medium text-gray-700">TA (Travel Allowance):</label>
                    <input type="text" name="manual_ta[]" id="manual_ta" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="da" class="block text-sm font-medium text-gray-700">DA (Daily Allowance):</label>
                    <input type="text" name="da" id="da" value="{{ $daAmountFromBackend }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" readonly>
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount:</label>
                    <input type="number" name="manual_total_amount[]" id="total_amount_manual" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
                <td class="mb-4 dsa-settlement-no-advance">
                    <label for="remark" class="block text-sm font-medium text-gray-700">Remarks:</label>
                    <input type="text" name="manual_remark[]" id="remark" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </td>
            </tr>
        </table>
        <div class="mb-4">
            <button type="button" id="addManualSettlementButton" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 0.5rem; border-radius: 0.25rem; cursor: pointer;">Add Manual Settlement</button>
        </div>
        <div class="mb-4">
            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 0.5rem; border-radius: 0.25rem; cursor: pointer;">Submit</button>
        </div>
    </form>   
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

    




</x-app-layout>


    