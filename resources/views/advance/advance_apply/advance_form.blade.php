<!-- resources/views/advance_form.blade.php -->

@extends('layout')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('Add_Advance') }}" enctype="multipart/form-data" id="advanceForm">
            @csrf
            <div class="p-6 bg-white border-b border-gray-200">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            <div class="form-group">
                <label for="advance_type_id">Advance Type</label>
                <select name="advance_type_id" class="form-control" id="advanceType" required>
                    @foreach ($advance_type as $advance)
                        <option value="{{ $advance->id }}">{{ $advance->name }}</option>
                    @endforeach
                </select>
            </div>
             <!-- Dynamic Fields Based on Advance Type -->
            <div id="dynamicFields">
                <!-- JavaScript will populate fields here -->
            </div>
               <!-- Common Fields -->
               <div class="form-group">
                <label for="upload_file">Upload File</label>
                <input type="file" name="upload_file" class="form-control-file" accept=".pdf">
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
                        <div class="form-group">
                            <label for="mode_of_travel">Mode of Travel</label>
                            <input type="text" name="mode_of_travel" class="form-control" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="from_location">From Location</label>
                            <input type="text" name="from_location" class="form-control" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="to_location">To Location</label>
                            <input type="text" name="to_location" class="form-control" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    `;
                } else if (selectedType === 'Salary Advance') {
                    dynamicFields.innerHTML = `
                        <!-- fields for Salary Advance -->
                        <div class="form-group">
                            <label for="emi_count">EMI Count</label>
                            <input type="number" name="emi_count" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="deduction_period">Deduction Period</label>
                            <input type="date" name="deduction_period" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    `;
                } else if (selectedType === 'General Imprest Advance' || selectedType === 'Electricity Imprest Advance') {
                    dynamicFields.innerHTML = `
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" class="form-control" maxlength="255" required>
                        </div>
                    `;
                } else if (selectedType === 'SIFA Loan') {
                    dynamicFields.innerHTML = `
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" min="0" required onchange="calculateTotalAndMonthly()">
                    </div>
                    <div class="form-group">
                        <label for="interest_rate">Interest Rate</label>
                        <input type="number" name="interest_rate" class="form-control" min="0" required onchange="calculateTotalAndMonthly()">
                    </div>
                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" min="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="emi_count">EMI Count</label>
                        <input type="number" name="emi_count" class="form-control" min="1" required onchange="calculateTotalAndMonthly()">
                    </div>
                    <div class="form-group">
                        <label for="monthly_emi_amount">Monthly EMI Amount</label>
                        <input type="number" name="monthly_emi_amount" class="form-control" min="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="deduction_period">Deduction Period</label>
                        <input type="date" name="deduction_period" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose</label>
                        <input type="text" name="purpose" class="form-control" maxlength="255" required>
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








</script>






@endsection
