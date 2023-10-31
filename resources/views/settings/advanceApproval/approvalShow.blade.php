
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
                    <h3 class="page-title">Approval Rules</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Setting Management/Approval </li>
                    </ul>
                </div>
                @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row mt-4">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                        

                    <form method="POST" action="{{ route('advance-approval.update', $approvalRule->id)}}">
                        @csrf
                        @method('patch')
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">View Approval Rule</h4>  
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">For<span class="text-danger">*</span></label>
                                                <select id="For" name="For"   class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                <option disabled selected value="{{ $approvalRule->For}}">{{ $approvalRule->For}}</option>
                                                <option value="Leave">Leave</option>
                                                </select>
                                                @error('For')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Type<span class="text-danger">*</span></label>
                                                <select id="type" name="Type" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                                <option {{ $approvalRule->For ==='Expense' ? 'readonly' : ''}}>
                                                {{ $approvalRule->For === 'Expense' ? $approvalRule->types->name : $approvalRule->type->name }}
                                                </option>
                                                </select>
                                                @error('Type')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Rule Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="RuleName" id="name" value="{{ $approvalRule->RuleName }}">
                                                    @error('RuleName')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label class="col-form-label form-select-md">Status</label>
                                                <select id="status" name="status" class="form-select" aria-label="Default select example" style="height:45px">
                                                <option value="{{ $approvalRule->status}}">Choose status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                </div>
                                            </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="start_date">Start Date:</label>
                                                <input type="date" id="start_date" name="start_date"  value="{{ $approvalRule->start_date }}" class="form-control" required>
                                                @error('start_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror  
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="end_date">Start Date:</label>
                                                <input type="date" id="end_date" name="end_date" value="{{ $approvalRule->end_date }}" class="form-control" required>
                                                @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror  
                                            </div>
                                        </div>
                                           
                                        </div>  
                                        <div class="modal-footer justify-content-start mt-3">
                                    <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                    &nbsp;  &nbsp;   &nbsp;
                                    <a href="{{ route('advance-condition.create', ['approval_rule_id' => $approvalRule->id]) }}" class="btn add-btn"><i class="fa fa-plus"></i>Add Condition</a>
                                </div>  
                                    </div>
                                
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>       


         <!-- Table -->
         <div class="row mt-4">
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
                                    <th>Formula</th>
                                    <th>Hierarchy Name</th>
                                    <th>Single User</th>
                                    <th>Auto Approval</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($specificConditions as $key => $approval_condition)
                                <tr>
                                <th style="width: 30px;">
                                    <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                    </label>
                                </th>
                                <td>
                                    @foreach ($formulas as $collection)
                                        @foreach ($collection as $formula)
                                            {{ $formula->condition }}{{ $formula->field }} {{ $formula->operator }} @if($formula->value) {{ $formula->value }} @else {{ $formula->employee->name}} @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                @if ($approval_condition->approval_type === 'Hierarchy')
                                    <td>{{ $approval_condition->hierarchy->name }}</td>
                                    <td>No</td>
                                    <td>No</td>
                                @elseif ($approval_condition->approval_type === 'Single User')
                                    <td>No</td>
                                    <td>{{ $approval_condition->employee_id }}</td>
                                    <td>No</td>
                                @elseif ($approval_condition->approval_type === 'Auto Approval')
                                    <td>No</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                @endif
                                
                                <td class="text-right"> 
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('formula.createForApprovalCondition', $approval_condition->id)}}" class="btn btn-primary">
                                         <i class="fa fa-plus"></i>Formula
                                        </a>
                                        <span class="icon-spacing"></span>
                                        <a href="{{ route('advance-approval_condition.edit', $approval_condition->id)}}">    
                                            <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                                        </a>
                                    </div>
                                </td>
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
        <!-- Table -->
    </div><!-- /Page Content --> 
</div> 
<!-- /Page Wrapper -->
              
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    // Listen for changes in the hierarchy select field
    document.getElementById('hierarchy_id').addEventListener('change', function () {
        // Get the selected hierarchy ID
        const hierarchyId = this.value;

        // Send an AJAX request to fetch levels associated with the selected hierarchy
        fetch(`/levels/${hierarchyId}`)
            .then(response => response.json())
            .then(levels => {
                const levelSelect = document.getElementById('MaxLevel');
                levelSelect.innerHTML = ''; // Clear existing options

                // Add options for each level
                levels.forEach(level => {
                    const option = document.createElement('option');
                    option.value = 'Level'+level.level;
                    option.textContent = 'Level'+level.level;
                    levelSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error(error);
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



