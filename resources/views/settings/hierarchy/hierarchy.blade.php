
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
                            <h3 class="page-title">Hierarchy</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Setting Management/Hierarchy</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
						<a href="{{route('hierarchy.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>Add New Hierarchy </a>
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
                        <th>Hierarchy Name</th>   
                        <th>Action</th>   
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($hierarchies as $key => $hierarchy)
                    <tr>
                        <td style="width: 30px;">
                            <label>
                                <input type="checkbox" id="selectAllCheckbox">
                                <span>{{ $key + 1 }}</span>
                            </label>
                        </td>
                        <td>{{ $hierarchy->name }}</td>
                        <td class="text-right">
                            <div class="d-flex align-items-center">
                                        <a href="{{ route('hierarchy.show', ['hierarchy_id' => $hierarchy->id])}}">
                                            <i class="bi bi-pencil h3" style="color:#4889CB"></i></a>
                                        <span class="icon-spacing"></span>
                            
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                                    </form>
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
    $(document).ready(function() {
    // Initialize datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'MM-DD-YYYY', // Set the desired date format
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



