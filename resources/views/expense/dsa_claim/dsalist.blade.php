
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
                    <h3 class="page-title">DSA Claim/Settlement</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard/Expense Management/DSA Claim/DSA Claim List</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->     
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
                                            <th>Employee</th>
                                            <th>Creation Date</th>
                                            <th>Total Payable Amount</th>
                                            <th>Adv.Balance Amt Date</th>
                                            <th>Total Amt</th>
                                            <th>Status</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dsa as $key=> $dsa)
                                        <tr>
                                            <td style="width: 30px;">
                                                <label>
                                                    <input type="checkbox" id="selectAllCheckbox">
                                                    <span>{{ $key + 1 }}</span>
                                                </label>
                                            </td>
                                            <td>{{ $dsa->user->name}}</td>
                                            <td>{{ $dsa->created_at}}</td>
                                            <td>{{ $dsa->total_amount_adjusted }}</td>
                                            <td>{{ $dsa->net_payable_amount }}</td>
                                            <td>{{ $dsa->balance_amount }}</td>
                                            <td>
                                            @if ($dsa->status === 'pending')
                                                <button class="btn btn-warning">Pending</button>
                                            @elseif ($dsa->status === 'approved')
                                                <button class="btn btn-success">Approved</button>
                                            @elseif ($dsa->status === 'rejected')
                                                <button class="btn btn-danger">Rejected</button>
                                            @endif
                                            </td>
                                            <td>{{ $dsa->remark}}</td>
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
</div><!-- Page Wrapper -->     
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
