
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
                    <!-- DSA Advance Form -->
                    <div id="dsa_advance_form" class="advance-fields" style="display: none;">
                        <form method="POST" action="{{ route('Add-Advance') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="advance_type" value="dsa_advance">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Mode of Travel<span class="text-danger">*</span></label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="model_of_travel" name="mode_of_travel" required>
                                        <option value="car">Car</option>
                                        <option value="Bike">Bike</option>
                                        <option value="Flight">Flight</option>
                                        <option value="Bus">Bus</option>
                                        <option value="Train">Train</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Amount<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" id="amount" name="amount" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>From Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="from_date" name="from_date" :value="old('from_date')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>To Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="to_date" name="to_date" :value="old('to_date')"required>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">From Location<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="from_location" name="from_location" :value="old('from_location')" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">To Location<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="to_location" name="to_location" :value="old('to_location')" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Purpose<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="purpose" name="purpose" required>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                <div class="form-group">
                                <label for="upload_file" class="form-label">{{ __('Upload File (Optional)') }}</label>
                                <input id="upload_file" class="form-control" type="file" name="upload_file" accept=".pdf" />
                                </div>
                            </div> 
                            </div>   
                                           
                            <div class="modal-footer justify-content-start mt-3">
                            <button type="submit" class="btn btn-primary">Submit DSA Advance</button>
                            </div>
                        </form>
                    </div>
                    <!-- DSA Advance Form -->

                    <!-- Salary Advance Form -->
                    <div id="salary_advance_form" class="advance-fields" style="display: none;">
                        <form method="POST" action="{{ route('Add-Advance') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="advance_type" value="salary_advance">

                            <!-- Salary Advance fields here -->
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">EMI Count<span class="text-danger">*</span></label>
                                    <input class="form-control" type="number"  id="emi_count" name="emi_count" min="1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="col-form-label">Amount<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" id="amount" name="amount">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="col-form-label">Purpose<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="purpose" name="purpose">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label for="upload_file" class="form-label">{{ __('Upload File (Optional)') }}</label>
                                <input id="upload_file" class="form-control" type="file" name="upload_file" accept=".pdf" />
                                </div>
                            </div>   
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Deduction Period<span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="deduction_period" name="deduction_period">
                                    </div>
                                </div>
                            </div>     
                        </div>                                                   
                        <div class="modal-footer justify-content-start mt-3">
                            <button type="submit" class="btn btn-primary">
                                Submit Salary Advance</button>
                        </div> 
                    </form>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Advance/Loan Type<span class="text-danger">*</span></label>
                            <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="advance_type" name="advance_type">
                                <option value="none">Select Adance Type</option>
                                @foreach ($advance_type as $advancetype)
                                <option value="{{ $advancetype->name }}">{{ $advancetype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </div>
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



