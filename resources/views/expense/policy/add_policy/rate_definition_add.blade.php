

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
                                <h5 class="modal-title">Add Rate Definition</h5>
                            </div>
                <div class="modal-body">
                    <div class="card tab-box">
						<div class="row user-tabs">
							<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
								<ul class="nav nav-tabs nav-tabs-bottom">
									<li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Expense Policy</a></li>
									<li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link active">Rate Definition</a></li>
									<li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Policy Enforcement</a></li>
                                    <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Complete</a></li>
								</ul>
							</div>
						</div> 
                    </div>

                <form method="POST" action="{{ route('store-rate-definition') }}">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="policy_id" name="policy_id" value="{{ $policy->id  }}">
                                @error('policy_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>                   
                        <div class="form-group">
                            <label for="attachment_required">Attachment Required:</label>
                                <input type="checkbox" id="attachment_required" name="attachment_required" value="1">
                                    @error('attachment_required')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                        </div>
                    <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Travel Type</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="travel_type" name="travel_type">
                                            <option value="domestic">Domestic</option>
                                        </select>
                                    @error('travel_type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Rate Currency Type -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Type</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="type" id="type">
                                            <option value="Single Currency">Single Currency</option>
                                        </select>
                                   @error('type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Rate Currency</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="name" name="name">
                                            <option value="Nu">Nu</option>
                                        </select>
                                </div>
                            </div>
                    
                            <!-- Rate Limit -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Rate Limit</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="rate_limit" id="rate_limit">
                                                <option value="daily">Daily</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                        </select>
                                        @error('rate_limit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-auto p-4">
                            <button  class="btn add-btn" type="submit"><i class="fa fa-plus"></i>Create Limit</button>
                            &nbsp;  &nbsp;   &nbsp;
                            </div>
                        </div>
                   
                    <h2>Limit</h2>
                        <!-- Table -->
                        <div class="row">
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
                                                            <th>Grade</th>
                                                            <th>Region</th>
                                                            <th>Limit Amount</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Status</th>        
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($rateLimits as $key => $rateLimit)
                                                            <tr>
                                                            <th style="width: 30px;">
                                                            <label>
                                                                <input type="checkbox" id="selectAllCheckbox">
                                                                <span>{{ $key + 1 }}</span>
                                                            </label>
                                                                </th>
                                                                <td>{{ $rateLimit->gradeName->name }}</td>
                                                                <td>{{ $rateLimit->region }}</td>
                                                                <td>{{ $rateLimit->limit_amount }}</td>
                                                                <td>{{ $rateLimit->start_date }}</td>
                                                                <td>{{ $rateLimit->end_date }}</td>
                                                                <td>{{ $rateLimit->status ? 'Active' : 'Inactive' }}</td>
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
                                <!-- End Table -->
                                <!-- Button -->
                                <div class="modal-footer justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Previous</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <a href="{{ route('policy-enforcement.index', ['policy' => $policy]) }}" style="text-decoration: none;">
                                        <button type="button" class="btn btn-primary">
                                            {{ __('Save And Submit') }}
                                        </button>
                                    </a>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                                </div> 
                                <!--/End Button -->
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



