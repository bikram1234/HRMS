
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
                    <h3 class="page-title">Expense Type</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard/Expense Management/Expense Type</li>
                        </ul>
                </div>
                    <div class="col-auto float-right ml-auto">
                    <a href="{{route('expense-types')}}" class="btn add-btn" data-toggle="modal" data-target="#add_expense_type"><i class="fa fa-plus"></i>Add Expense Type</a>
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
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach($expenseTypes as $key => $expenseType)
                                        <tr>
                                            <th style="width: 30px;">
                                                <label>
                                                <input type="checkbox" id="selectAllCheckbox">
                                                <span>{{ $key + 1}}</span>
                                                </label>
                                            </th>
                                            <td>{{ $expenseType->name }}</td>
                                            <td>{{ $expenseType->start_date}}</td>
                                            <td>{{ $expenseType->end_date}}</td>
                                            @if($expenseType->status === 'enforce')
                                            <td><button class="btn status-button" type="button">Enforce</button></td>
                                            @else
                                            <td><button class="btn inactive-button " type="button">Draft</button></td>
                                            @endif
                                        </tr>
                                </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
<!--Add Expense Type-->
<div id="add_expense_type" class="modal custom-modal fade" role="dialog">
        <form action="{{ route('expense-types')}}" method="POST">
            @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Expense Name<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name"required>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                <div class="cal-icon">
                    <input  name="start_date" id="start_date" class="form-control datetimepicker" type="date"  required>
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                </div>
            </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                <label for="start_date">End Date <span class="text-danger">*</span></label>
                <div class="cal-icon">
                    <input  name="end_date" id="end_date" class="form-control datetimepicker" type="date" >
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                            </div>
                        </div>
                        </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label form-select-md">Status</label>
                                        <select class="form-select" aria-label="Default select example" style="height:45px" name="status" id="status">
                                            <option value="enforce">Enforce</option>
                                            <option value="draft">Draft</option>
                                        </select>
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
<!-- End Expense Add -->

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


@endsection



