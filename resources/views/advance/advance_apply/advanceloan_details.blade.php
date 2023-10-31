
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
                            <h3 class="page-title">Advance/Loan Apply</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/AdvanceLoanManagement/Advance/Loan Apply</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">

                        <button type="button" class="btn add-btn" onclick="window.location.href='{{ route('show_advance') }}'">
                        <i class="fa fa-plus"></i>
                            {{ __('Apply Advance') }}
                        </button> 
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
                                    <th>Advance No</th>
                                    <th>Advance/Loan Type</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Advanceapplication as $key => $advance)
                                <tr>
                                    <th style="width: 30px;">
                                        <label>
                                            <input type="checkbox" id="selectAllCheckbox">
                                            <span>{{ $key + 1 }}</span>
                                        </label>
                                    </th>
                                    <td>{{ $advance->advance_no }}</td>
                                    <td>{{ $advance->advanceType->name }}</td>
                                    <td>{{ $advance->date}}</td>
                                    <td>{{ number_format($advance->amount, 2)}}</td>
                                    <td>
                                        @if ($advance->status === 'pending')
                                            <button class="btn btn-warning">Pending</button>
                                        @elseif ($advance->status === 'approved')
                                            <button class="btn btn-success">Approved</button>
                                        @elseif ($advance->status === 'rejected')
                                            <button class="btn btn-danger">Rejected</button>
                                        @endif
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
</div>
<!-- /Page Content -->

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


@endsection



