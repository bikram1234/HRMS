
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
                                <h5 class="modal-title">Complete</h5>
                            </div>
                        <div class="modal-body">
                            <div class="card tab-box">
                                <div class="row user-tabs">
                                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                        <ul class="nav nav-tabs nav-tabs-bottom">
                                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link">Expense Policy</a></li>
                                            <li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link">Rate Definition</a></li>
                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Policy Enforcement</a></li>
                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link active">Complete</a></li>
                                        </ul>
                                    </div>
                                </div> 
                            </div>

                            <!-- ===========================================COMPLETE============================================================================== -->
                            
                            <div class="modal-content">
                                <div class="modal-body">
                                 <!--======================== Leave Policy ============================-->
                                <div id="divleavepolicy">
                                    <h4>Expense Policy</h4>
                                    <div class="row">
                                        <span class="col-sm-3">Expense Type</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">DSA Settlement</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Policy Name</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $policy->name}}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Policy Description</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $policy->description }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Start Date</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $policy->start_date}}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">End Date</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $policy->end_date}}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Status</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $policy->status}}</div>
                                        </div>
                                    </div>

                                   
                                 </div>
                                 <!--====================== End Leave Policy============================ -->
                                 <!-- ========================LEAVE PLAN============================================= -->
                                 <div id="divleavepolicy mt-3">
                                    <h4>Rate Definition</h4>
                                    <div class="row">
                                        <span class="col-sm-3">Attachement Required</span>
                                        <div class="col-sm-9">
                                        <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        </label>
                                        </div>
                                    </div>
                                    @foreach ($rateDefinitions as $rateDefinition)

                                    <div class="row">
                                        <span class="col-sm-3">Travel Type</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign"> {{ $rateDefinition->travel_type }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Rate Currency(Type)</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign"> {{ $rateDefinition->type }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Rate Currency(Name)</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign"> {{ $rateDefinition->name }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="col-sm-3">Rate Limit</span>
                                        <div class="col-sm-9">
                                            <div id="leavetype" class="cmplitetexalign">{{ $rateDefinition->rate_limit }}</div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <!-- =================================TABLE====================================== -->

                                        <div class="row mt-5">
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
                                            @foreach ($rateLimits as $rateLimit)
                                            <tr>
                                            <th style="width: 30px;">
                                            <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                <span>1</span>
                                                </label>
                                                </th>
                                                <td>{{ $rateLimit->gradeName->name }}</td>
                                                <td>{{ $rateLimit->region }}</td>
                                                <td>{{ $rateLimit->limit_amount }}</td>
                                                <td>{{ $rateLimit->start_date }}</td>
                                                <td>{{ $rateLimit->end_date }}</td>
                                                <td>{{ $rateLimit->status }}</td>
                                                <!-- <td><button class="btn status-button" type="button">Active</button></td> -->
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                 <!-- ========================YEAR END PROCESSING============================================= -->
                            
                                        </div>
                                        </div>
                                        </div>
                                        </div>

                                    
                                    <div id="divleavepolicy mt-3">
                                    <h4>Policy Enforcement</h4>
                                    @if ($policyEnforcements)
                                    <div class="form-group">
                                    </label><input type="checkbox" {{ $policyEnforcements->prevent_submission ? 'checked' : '' }} disabled>Prevent report submission</label>
                                    </div>
                                    <div class="form-group">
                                    </label> <input type="checkbox"  {{ $policyEnforcements->display_warning ? 'checked' : '' }} disabled> Display warning to user</label>
                                    </div>
                                    </div>
                                        <!-- Add more draft policy enforcement fields as needed -->
                                    @else
                                        <p>No draft data for policy enforcement.</p>
                                    @endif
                                    </div>                                  
                                     <!-- =================================END TABLE====================================== -->
                                   
                                 </div>
                                 <!-- ========================================END LEAVE PLAN================================================= -->
                            </div>
                        </div>
                   
            <!-- =====================================================END COMPLETE======================================================= -->
           


                           
    
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



