
@extends('layouts.index')

@section('content')
<style>
 .status-button {
background-color:#17c964;
 border-radius: 5px;
}

.status-button:hover{
    background-color:#17c964;
}
.inactive-button {
background-color:#f5a524;
 border-radius: 5px;
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
                    <h3 class="page-title">Advance/Loan Type</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/Advance/Loan Type</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('add-advance')}}" class="btn add-btn" data-toggle="modal" data-target="#add_advance_type"><i class="fa fa-plus"></i>Add Advance Type</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->  
    <div class="row">
    @if(session('success'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('success') }}
        </div>
    @endif
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
                                        <th>Advance/Loan Type</th>
                                        <th>Expense Type</th>
                                        <th>Star Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($advances as $key => $advance)
                                    <tr id="advance-{{ $advance->id }}">
                                        <th style="width: 30px;">
                                        <label>
                                        <input type="checkbox" id="selectAllCheckbox">
                                        <span>{{ $key + 1 }}</span>
                                        </label>
                                        </th>
                                        <td>{{ $advance->name }}</td>
                                        <td>{{ $advance->expense_type}}</td>
                                        <td>{{ $advance->start_date}}</td>
                                        <td>{{ $advance->end_date}}</td>
                                        @if($advance->status === 'enforce')
                                        <td><button class="btn status-button" type="button">Enforce</button></td>
                                        @else
                                        <td><button class="btn inactive-button" type="button">Draft</button></td>
                                        @endif
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
</div>
<!-- /Page Content -->           
<!-- Add advance type-->
<div id="add_advance_type" class="modal custom-modal fade" role="dialog">
    <form action="{{ route('add-advance')}}" method="POST">
            @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Advance Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Advance/Loan Type<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label form-select-md">Expense Type</label>
                        <select class="form-select" style="height:45px" name="expense_type_id" id="expense_type_id">
                            <option value="">Select an expense type</option>
                            @foreach ($expenseTypes as $expenseType)
                            <option value="{{ $expenseType->id}}">{{ $expenseType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                        @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="start_date" class="form-control">
                        @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
    </div>
    <div class="modal-footer justify-content-start">
        <button type="submit" class="btn btn-primary">Add Expense Type</button>
    </div>
</div>
</div>
</form>
</div>
<!-- Add advance type -->

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
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD', // Set the desired date format
        // Add any other options you need
    });
});
</script>

<script>
$(document).ready(function () {
    $("#example").DataTable();
});
</script>


@endsection



