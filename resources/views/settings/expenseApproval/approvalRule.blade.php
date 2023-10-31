
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

<style>
.word-container {
    display: flex;
    gap: 50px; /* Adjust the gap as needed */
}

.word {
    white-space: nowrap; /* Prevent words from breaking to new lines */
}
.word a {
        text-decoration: none;
        color: black;
    }
    .word.active a{
    /* text-decoration: underline; */
    color: #338EF7;
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
                    <h3 class="page-title">Expense Approval Rules</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Setting Management/Expense Approval Rule </li>
                    </ul>
                </div>
                @if(session('success'))
                    <div id="success-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('expense-approval.create')}}" class="btn add-btn" data-toggle="modal" data-target="#add_expense_approval"><i class="fa fa-plus"></i>Add Expense Approval Rule</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row mt-4">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                        <div class="word-container mb-4">
                            <span class="word"><a href="">Leave</a></span>
                            <span class="word active"><a href="">Expense</a></span>
                            <span class="word"><a href="">Advance/Loan</a></span>
                            <span class="word"><a href="">Leave Enchasment</a></span>
                            
                        </div>
                        <hr>
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
                                    <th>Type</th>
                                    <th>Rule Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvals as $key => $approval)
                                <tr>
                                <th style="width: 30px;">
                                    <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                    </label>
                                </th>
                                @if ($approval->For === 'Expense')
                                <td>{{ $approval->types->name }}</td>
                                @else
                                <td>{{ $approval->type->name }}</td>
                                @endif
                                <td>{{ $approval->RuleName }}</td>
                                <td>{{ $approval->start_date }}</td>
                                <td>{{ $approval->end_date }}</td>
                                @if($approval->status == 1)
                                <td><button class="btn status-button" type="button">Active</button></td>
                                    @else
                                <td><button class="btn inactive-button " type="button">Inactive</button></td>
                                @endif
                                <td class="text-right"> 
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('expense-approval.show', ['approvalRule' => $approval->id])}}">
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
    </div><!-- /Page Content -->

    <!-- Add Approval rule -->
            <div id="add_expense_approval" class="modal custom-modal fade" role="dialog">
                <form method="POST" action="{{ route('expense-approval.store')}}">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Expense Approval Rule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">For<span class="text-danger">*</span></label>
                                            <select id="For" name="For" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <option disabled selected>Select Level</option>
                                            <option value="Expense">Expense</option>
                                            </select>
                                            @error('For')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Type<span class="text-danger">*</span></label>
                                            <select id="Type" name="type_id" class="form-select  form-select-md" aria-label="Default select example" style="height:45px">
                                            <!-- Options will be dynamically populated here -->
                                            </select>
                                            @error('type_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Rule Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="RuleName" id="RuleName">
                                                @error('RuleName')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                      

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                                            @error('start_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror  
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="end_date">Start Date:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control" required>
                                            @error('end_date')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror  
                                        </div>
                                    </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                            <label class="col-form-label form-select-md">Status</label>
                                            <select id="status" name="status" class="form-select" aria-label="Default select example" style="height:45px">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            <div class="modal-footer justify-content-start">
                                <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
    <!-- End Add  Expense Approval Rule -->
</div> 
<!-- /Page Wrapper -->
              
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        var forSelect = document.getElementById('For');
        var typeSelect = document.getElementById('Type');
        
        // ...

        // Function to populate the "Type" dropdown based on the selected "For" value
        function populateTypeDropdown(selectedFor) {
            typeSelect.innerHTML = ''; // Clear existing options
            
            if (selectedFor === '') {
                // If "Choose For:" is selected, display the default "Select For First" option
                var defaultOption = document.createElement('option');
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = 'Select For First';
                typeSelect.appendChild(defaultOption);
            } else {
                // Define and populate options based on the selected "For" value
                var options;
            if (selectedFor === 'Expense') {
                options = {!! json_encode($expenses->pluck('name', 'id')) !!};
            } else {
                // Default empty options
                options = [];
            }
                
                // Populate the "Type" dropdown with options
                for (var id in options) {
                    if (options.hasOwnProperty(id)) {
                        var optionElement = document.createElement('option');
                        optionElement.value = id; // Set the value to the ID
                        optionElement.textContent = options[id]; // Set the text content to the name
                        typeSelect.appendChild(optionElement);
                    }
                }
            }
        }

        // Initially populate the "Type" dropdown when the page loads
        populateTypeDropdown(forSelect.value);

        // ...

        forSelect.addEventListener('change', function () {
            var selectedFor = forSelect.value;
            populateTypeDropdown(selectedFor);
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



