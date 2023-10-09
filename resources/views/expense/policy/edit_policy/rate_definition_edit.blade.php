

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

                        <div class="form-group">
                            <input type="hidden" id="policy_id" name="policy_id" value="{{ $policy->id  }}">
                               
                        </div>                   
                        <div class="form-group">
                            <label for="attachment_required">Attachment Required:</label>
                                <input type="checkbox" id="attachment_required" name="attachment_required" value="1" {{ $rateDefinition->attachment_required ? 'checked': ''}} readonly>
                                   
                        </div>
                    <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Travel Type</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="travel_type" name="travel_type" @if($rateDefinition->travel_type) disabled @endif>
                                            <option value="domestic" {{ $rateDefinition->travel_type == 'domestic' ? 'selected' : ''}} readonly>Domestic</option>
                                        </select>
                                   
                                </div>
                            </div>
                            <!-- Rate Currency Type -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Type</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="type" id="type">
                                            <option value="Single Currency" {{ $rateDefinition->type == 'Single Currency' ? 'selected' : ''}} readonly>Single Currency</option>
                                        </select>
                                  
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Rate Currency</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" id="name" name="name">
                                            <option value="Nu"{{ $rateDefinition->name == 'Nu'? 'selected':''}} readonly>Nu</option>
                                        </select>
                                </div>
                            </div>
                    
                            <!-- Rate Limit -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Rate Limit</label>
                                        <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="rate_limit" id="rate_limit" @if($rateDefinition->rate_limit) disabled @endif>
                                                <option value="daily" {{ $rateDefinition->rate_limit == 'daily' ? 'selected' : ''}}>Daily</option>
                                                <option value="monthly" {{ $rateDefinition->rate_limit == 'monthly' ? 'selected' : ''}}>Monthly</option>
                                                <option value="yearly"{{ $rateDefinition->rate_limit == 'yearly' ? 'selected' : ''}}>Yearly</option>
                                        </select>
                                       
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
                                                            <th>Action</th>   
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
                                                                <td class="text-right">
                                                                <div class="d-flex align-items-center">
                                                                <a href="{{ route('edit-rate-limit', ['rateLimit' => $rateLimit->id])}}" data-toggle="modal" data-target="#edit_rateLimit{{$rateLimit->id}}">
                                                                    <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                                                </a>
                                                                </div>
                                                                </td>
                                                            </tr> 
                                                        @endforeach
                                                        </tbody>

                            <!-- Edit rate limit-->
                                            
                                <div  id="edit_rateLimit{{$rateLimit->id}}" class="modal custom-modal fade" role="dialog">
                                <form method="POST" action="{{ route('update-rate-limit', ['rateLimit' => $rateLimit->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Expense Policy</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                            <div class="modal-body">
                                                <div class="card tab-box">
                                                <div class="row user-tabs">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                                        <ul class="nav nav-tabs nav-tabs-bottom">
                                                            <li class="nav-item"><a href="#hierarchyFields" data-toggle="tab" class="nav-link active">Expense Policy</a></li>
                                                            <li class="nav-item"><a href="#leave_plan" data-toggle="tab" class="nav-link">Rate Defination</a></li>
                                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Policy Enforcement</a></li>
                                                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Complete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
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
                                    <div class="modal-footer justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Edit Rate Limit</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <a href="{{ route('edit-rate-limit', ['rateLimit' => $rateLimit])}}"></a>Cancel</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    </div>
                                </div>                           
                             </div>
                        </div>
                    </form>
                </div>
         <!-- /Edit rate limit-->
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



