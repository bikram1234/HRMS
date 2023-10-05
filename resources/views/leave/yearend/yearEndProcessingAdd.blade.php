

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
                                <h5 class="modal-title">Year End Processing</h5>
                            </div>
                    <div class="modal-body">
                     <div class="card tab-box">
						<div class="row user-tabs">
							<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
								<ul class="nav nav-tabs nav-tabs-bottom">
									<li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Leave Policy</a></li>
									<li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link">Leave Plan</a></li>
									<li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link active">Year End Processing</a></li>
                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Summary</a></li>
								</ul>
							</div>
						</div> 
                    </div>
                    <!-- Year End Process -->               
                    <div class="container mt-5">
                        <form method="POST" action="{{ route('yearendprocessing.store') }}">
                            @csrf
                        <div class="form-group">
                                    <input type="hidden" id="leave_id" name="leave_id" value="{{ $leave_id }}">
                                    @error('leave_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="allow_carryover">Allow Carry Over:</label>
                                <input type="checkbox" id="allow_carryover" name="allow_carryover" value="1">
                                @error('allow_carryover')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="carryover_limit">Carry Over Limit:</label>
                                <input type="number" id="carryover_limit" name="carryover_limit" class="form-control" value="0">
                                @error('carryover_limit')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="payat_yearend">Pay at Year-End:</label>
                                <input type="checkbox" id="payat_yearend" name="payat_yearend" value="1">
                                @error('payat_yearend')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="min_balance">Minimum Balance Need to be maintained:</label>
                                <input type="number" id="min_balance" name="min_balance" class="form-control">
                                @error('min_balance')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="max_balance">Maximum Balance Encashment Per Year:</label>
                                <input type="number" id="max_balance" name="max_balance" class="form-control">
                                @error('max_balance')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="carryforward_toEL">Carry Forward to EL:</label>
                                <input type="checkbox" id="carryforward_toEL" name="carryforward_toEL" value="1">
                                @error('carryforward_toEL')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label for="carryforward_toEL_limit">Carry Forward to EL Limit:</label>
                                <input type="number" id="carryforward_toEL_limit" name="carryforward_toEL_limit" class="form-control">
                                @error('carryforward_toEL_limit')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            </div>

                            <!-- Button -->
                            <div class="modal-footer justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Previous</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <!-- <button type="submit" class="btn btn-primary mt-4">Submit</button> -->
                                    <button type="submit" class="btn btn-primary" onclick="redirectToSummary()">Save & Continue</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                            </div> 
                            <!--/End Button -->
                        </form>
                    </div>
                    <!-- /End Year End Process -->
                    </div>
                </div>
            </div>       
        </div>
     <!-- /row -->
</div>
</div>
<!-- Page Content -->
</div>
<!-- /Page Wrapper -->

                
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 
<script>
    var leavePolicyId = {{ $leavePolicy->leave_id ?? 'null' }};
    function redirectToSummary() {
        if (leavePolicyId !== null) {
            var url = "{{ route('showSummary.show', ['leave_id' => ':leave_id']) }}".replace(':leave_id', leavePolicyId);
            window.location.href = url;
        }
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



