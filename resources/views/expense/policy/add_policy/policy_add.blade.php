

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
         <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Expense Policy</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard/Expense Management/Expense Policy</li>
                        </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                <a href="{{route('add-policy')}}" class="btn add-btn" data-toggle="modal" data-target="#add_expensepolicy"><i class="fa fa-plus"></i> Add ExpensePolicy</a>
                </div>
            </div>
        </div>
    <!-- /Page Header -->
                
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
                                <th>Expense Type</th>
                                <th>Policy Name</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                             </tr>
                            </thead>
                              <tbody>
                                @foreach($policies as $key => $policy)
                                <tr>
                                <th style="width: 30px;">
                                <label>
                                    <input type="checkbox" id="selectAllCheckbox">
                                    <span>{{ $key + 1 }}</span>
                                    </label>
                                    </th>
                                        <td>{{ $policy->expenseType->name }}</td>
                                        <td>{{ $policy->name }}</td>
                                        <td>{{ $policy->description }}</td>
                                        <td>{{ $policy->start_date }}</td>
                                        <td>{{ $policy->end_date }}</td>
                                        @if($policy->status === 'enforce')
                                        <td><button class="btn status-button" type="button">Enforce</button></td>
                                        @else
                                        <td><button class="btn inactive-button" type="button">Draft</button></td>
                                        @endif
                                        <td class="text-right">
                                        <div class="d-flex align-items-center">
                                        <a href="{{ route('edit-policy', ['policy' => $policy->id])}}" data-toggle="modal" data-target="#edit_expensepolicy{{$policy->id}}">
                                            <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                        </a>
                                        <span class="icon-spacing"></span>
                                        <a href="{{ route('view-policy', ['policy' => $policy->id]) }}">
                                            <i class="bi bi-eye-fill h3"></i>
                                        </a>

                                        </td>
                                        
                                <!-- Edit expensepolicy-->
                                 <div id="edit_expensepolicy{{$policy->id}}" class="modal custom-modal fade" role="dialog">
                                    <form method="POST" action="{{ route('update-policy', ['policy' => $policy->id]) }}">
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
                                                <div class="col-sm-12">
                                                <div class="form-group" id="hierarchyFields">
                                                    <label class="col-form-label" for="expense_type_id">Expense Type<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" id="expense_type" name="expense_type" value="{{ $policy->expenseType->name}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Policy Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" id="name" name="name" value="{{ $policy->name }}" readonly>
                                                </div>
                                            </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Policy Decription</label>
                                                        <div class="form-floating">
                                                        <textarea class="form-control"  style="height: 100px" id="description" name="description" value="{{ old('description', $policy->description)}}"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input  name="start_date" id="start_date" class="form-control datetimepicker" type="date" value="{{ old('start_date', $policy->start_date)}}" readonly>
                                                    </div>
                                                </div>
                                                </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                        <label>End Date <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" id="end_date" name="end_date"  type="date" value="{{ old('end_date', $policy->end_date)}}">
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                            <div class="form-group">
                                                            <label class="col-form-label form-select-md">Status</label>
                                                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                                                            <option value="enforce" {{ old('status') === 'enforce' ? 'selected' : '' }}>Enforce</option>
                                                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                                            </select>
                                                            @error('status')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                            @enderror

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-end mt-3">
                                                    <button type="submit" class="btn btn-primary">Edit Expense Policy</button>
                                                    <button type="button" class="btn btn-secondary"data-dismiss="modal"> <a href="{{ route('edit-policy', ['policy' => $policy->id]) }}"></a>Cancel</button>
                                                    </div>                            
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <!-- /Edit expensepolicy-->


                                    <!-- View Expensepolicy -->


                                    
                                    <!-- View Expensepolicy -->
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
<!-- Add expensepolicy-->
<div id="add_expensepolicy" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{ route('add-policy') }}">
    @csrf
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense Policy</h5>
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
                <div class="col-sm-12">
                <div class="form-group" id="hierarchyFields">
                    <label class="col-form-label" for="expense_type_id">Expense Type<span class="text-danger">*</span></label>
                    <select class="form-select  form-select-md" aria-label="Default select example" style="height:45px" name="expense_type_id" id="expense_type_id">
                    @foreach($expenseTypes as $expenseType)
                    <option value="{{ $expenseType->id }}">{{ $expenseType->name}}</option>
                    @endforeach
                    </select>
                    @error('expense_type_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-form-label">Policy Name<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="name" name="name">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Policy Decription</label>
                        <div class="form-floating">
                        <textarea class="form-control"  style="height: 100px" id="description" name="description"></textarea>
                        @error('policy_description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input  name="start_date" id="start_date" class="form-control datetimepicker" type="date">
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>
                </div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label>End Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" id="end_date" name="end_date"  type="date">
                            @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12">
                            <div class="form-group">
                            <label class="col-form-label form-select-md">Status</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
                            <option value="enforce" {{ old('status') === 'enforce' ? 'selected' : '' }}>Enforce</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                            @enderror

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Add Expense Policy</button>
                    <button type="button" class="btn btn-secondary"data-dismiss="modal">Cancel</button>
                    </div>
                                                        
                    </div>
                </div>
            </form>
        </div>
    <!-- /Add expensepolicy-->
    </div>
<!-- End Table -->
</div>
<!-- /Page Wrapper -->

                
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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



