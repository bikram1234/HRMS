

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
                                <h5 class="modal-title">Edit Rate Definition</h5>
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
                                <!-- Edit Rate Limit -->
                                <form method="POST" action="{{ route('update-rate-limit', ['rateLimit' => $rateLimit->id]) }}">
                                @csrf    
                                @method('PUT')                          
                                <!-- Grade -->
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="grade">Grade:</label>
                                    <input class="form-control"  type="text" id="grade" value="{{ $rateLimit->grade}}" readonly>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="grade">Region:</label>
                                    <input class="form-control"  type="text" id="region" value="{{ $rateLimit->region}}" readonly>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="limit_amount">Limit Amount:</label>
                                    <input type="number" id="limit_amount" name="limit_amount" class="form-control"  value="{{ old('limit_amount', $rateLimit->limit_amount)}}" @if($rateLimit->limit_amount) readonly @endif>  
                                </div>
                              </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $rateLimit->start_date)}}" @if($rateLimit->start_date) readonly @endif> 
                                </div>
                            </div>

                            <div class="col-sm-6">
                            <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date',$rateLimit->end_date)}}" @if($rateLimit->end_date) @endif>
                                    
                                </div>
                            </div>
                                <div class="col-sm-6">
                                <div class="form-group md-3">
                                    <label for="status">Status:</label>
                                    <select class="form-control" id="status" name="status" @if($rateLimit->status) disabled @endif>
                                    <option value="active" {{ $rateLimit->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $rateLimit->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-middle mt-3">
                                    <button type="submit" class="btn btn-primary">Edit Rate Limit</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <a href="{{ route('edit-rate-limit', ['rateLimit' => $rateLimit->id])}}"></a>Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    </div>
                            </form>
           
                    <!-- /Edit Rate Limit-->
                    
                                                     
                                <!-- Button -->
                                <div class="modal-footer justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Previous</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <a href="{{ route('edit-policy-enforcement', ['policy' => $policy->id]) }}" style="text-decoration: none;">
                                        <button type="button" class="btn btn-primary">
                                            {{ __('Save And Continue') }}
                                        </button>
                                    </a>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='{{ route('edit-rate-definition', ['policy' => $policy->id])}}'">Cancel</button>
                                </div>
                                </div> 
                                <!--/End Button -->
                            </div>
                            </form>
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



