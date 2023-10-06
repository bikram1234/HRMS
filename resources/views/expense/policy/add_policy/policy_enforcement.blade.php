

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


.word {
 margin-left: 10px; 
 }
                            

</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
<!-- Page Content -->
<div class="content container-fluid">
<!-- row -->
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Policy Enforcement</h5>
                            </div>
                        <div class="modal-body">
                            <div class="card tab-box">
                                <div class="row user-tabs">
                                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                        <ul class="nav nav-tabs nav-tabs-bottom">
                                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Expense Policy</a></li>
                                            <li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link">Rate Definition</a></li>
                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link active">Policy Enforcement</a></li>
                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Complete</a></li>
                                        </ul>
                                    </div>
                                </div> 
                            </div>
                                <form method="POST" action="{{ route('policy-enforcement.store', ['policy' => $policy->id])}}">
                                @csrf
                                <div class="row">
                                <label class="mt-3">
                                <input class="form-checkbox" type="checkbox" id="prevent_submission" name="enforcement_options[]" value="prevent_submission">
                                    <span>Prevent Report Submission</span>
                                </label>
                                    
                                <label class="mt-3">
                                <input class="form-checkbox" type="checkbox" id="display_warning" name="enforcement_options[]" value="display_warning">
                                    <span>Display warning to User</span>
                                </label>

                                 <!-- Modal footer -->
                                 <div class="modal-footer justify-content-middle mt-3">
                                    <button type="submit" class="btn btn-primary">Previous</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="submit" class="btn btn-primary">Save and Continue</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    </div>
                            
                                </form>
    
                            </div>
                        </div>


                    </div>
                </div>
            </div>       
        </div>
     <!-- /row -->
    
</div>
<!-- Page Content -->
</div>
<!-- /Page Wrapper -->

                
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    function redirectToYearEndProcessing(url) {
        window.location.href = url;
    }
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
<script>
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>
@endsection



