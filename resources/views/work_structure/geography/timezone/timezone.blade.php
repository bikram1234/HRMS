
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
            @if(session('success'))
                <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Geography</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard/Work Structure/Geography</li>
                            </ul>
                        </div>
                            <div class="col-auto float-right ml-auto">
                            <a href="" class="btn add-btn" data-toggle="modal" data-target="#add_timezone"><i class="fa fa-plus"></i>Add TimeZone</a>
                            </div>
                    </div>
                </div>
                <!-- /Page Header -->
<style>.word-container {
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
<div class="row">
    <div class="col-md-12 stretch-card">
		<div class="card">
			<div class="card-body">
                <div class="col-md-12"> 
                    <div class="word-container mb-4">
                        <span class="word"><a href="{{route('country.index')}}">Country</a></span>
                        <span class="word active"><a href="{{ route('timezone.index') }}">TimeZone</a></span>
                        <span class="word"><a href="{{ route('region.index') }}">Region</a></span>
                        <span class="word"><a href="{{ route('dzongkhag.index') }}">Dzongkhag</a></span>
                        <span class="word"><a href="{{ route('storelocation.index') }}">StoreLocation</a></span>
                    </div>
                    <hr class="border:2px"> 
    <div class="container  table-responsive">  
      <table id="example" class="table table-striped custom-table" style="width: 100%">
        <thead>
          <tr>
            <th style="width: 30px;">
            <label>
            <input type="checkbox" id="selectAllCheckbox">
           <span>SI</span>
          </label>
          </th>
            <th>Time Zone</th>
            <th>Name and Abbreviation</th>
            <th>Country</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
             @foreach($timezones as $key => $timezone)
        <tr>
            <th style="width: 30px;">
            <label>
                <input type="checkbox" id="selectAllCheckbox">
                <span>{{ $key + 1 }}</span>
                </label>
                </th>
                <td>{{ $timezone->timezone }}</td>
                <td>{{ $timezone->name }}</td>
                <td>{{ $timezone->country->name }}</td>
                @if($timezone->status == 1)
                    <td><button class="btn status-button" type="button">Active</button></td>
                @else
                    <td><button class="btn inactive-button" type="button">Inactive</button></td>
                @endif
            <td class="text-right">
                <div class="d-flex align-items-center">
                    <a href="" data-toggle="modal" data-target="#edit_timezone{{$timezone->id}}">
                        <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                    </a>
                    <span class="icon-spacing"></span>
                    <form action="{{ route('timezone.delete', $timezone->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                   </form>
                </div>
            </td>
        </tr>
<!-- Edit timezone-->
<div id="edit_timezone{{ $timezone->id }}" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{route('timezone.update', $timezone->id)}}" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit TimeZone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">TimeZone<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="timezone" name="timezone" value="{{ $timezone->timezone }}" required>
                                @error('timezone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Name & Abbreviation<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" value="{{ $timezone->name }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="country_id form-select-md">Country</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="country_id" name="country_id" >
                                <option value="{{ $timezone->country_id }}">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name}}</option>
                                @endforeach
                            </select>
                      
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label form-select-md">Status</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
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
            <button type="submit" class="btn btn-primary">Update Country</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </form>
</div>
<!-- End Edit Country --> 


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
<!-- Add TimeZone-->
<div id="add_timezone" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{route('timezone.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add TimeZone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">TimeZone<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="timezone" name="timezone"  required>
                                @error('timezone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Name & Abbreviation<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="country_id form-select-md">Country</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="country_id" name="country_id">
                            <option selected disabled>Select Type</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id}}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                      
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label form-select-md">Status</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="status" name="status">
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
            <button type="submit" class="btn btn-primary">Add TimeZone</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </form>
</div>
<!-- End Add Timezone -->
				
</div>
<!-- /Page Wrapper -->
<!-- Add this in your HTML -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        
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
        format: 'MM-DD-YYYY', // Set the desired date format
        // Add any other options you need
    });
});
</script>
@endsection