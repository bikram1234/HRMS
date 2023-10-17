
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
                            <a href="" class="btn add-btn" data-toggle="modal" data-target="#add_dzongkhag"><i class="fa fa-plus"></i>Add Dzongkhag</a>
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
                        <span class="word"><a href="{{ route('timezone.index') }}">TimeZone</a></span>
                        <span class="word"><a href="{{ route('region.index') }}">Region</a></span>
                        <span class="word active"><a href="{{ route('dzongkhag.index') }}">Dzongkhag</a></span>
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
            <th>Code</th>
            <th>Dzongkhag Name</th>
            <th>Region</th>
            <th>Country</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
             @foreach($dzongkhags as $key => $dzongkhag)
        <tr>
            <th style="width: 30px;">
            <label>
                <input type="checkbox" id="selectAllCheckbox">
                <span>{{ $key + 1 }}</span>
                </label>
                </th>
                <td>{{ $dzongkhag->code }}</td>
                <td>{{ $dzongkhag->name }}</td>
                <td>{{ $dzongkhag->region->name }}</td>
                <td>{{ $dzongkhag->country->name }}</td>
                @if($dzongkhag->status == 1)
                    <td><button class="btn status-button" type="button">Active</button></td>
                @else
                    <td><button class="btn inactive-button" type="button">Inactive</button></td>
                @endif
            <td class="text-right">
                <div class="d-flex align-items-center">
                    <a href="" data-toggle="modal" data-target="#edit_dzongkhag{{$dzongkhag->id}}">
                        <i class="bi bi-pencil h3" style="color:#4889CB"></i>
                    </a>
                    <span class="icon-spacing"></span>
                    <form action="{{ route('dzongkhag.delete', $dzongkhag->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <i class="bi bi-trash3-fill h3" style="color:#f31260" id="delete"></i>
                   </form>
                </div>
            </td>
        </tr>
<!-- Edit dzongkhag-->
<div id="edit_dzongkhag{{ $dzongkhag->id}}" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{route('dzongkhag.update', $dzongkhag->id)}}" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dzongkhag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Code<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="code" name="code"  value="{{ $dzongkhag->code }}" required>
                                @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Dzongkhag Name<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="name" name="name"  value="{{ $dzongkhag->name }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="country_id form-select-md">Country</label>
                            <select class="form-select" aria-label="Default select example" style="height:45px" id="country_id" name="country_id">
                            <option value="{{ $dzongkhag->country_id}}" >Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id}}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                      
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="region_id form-select-md">Region</label>
                            <select id="region_id_{{ $dzongkhag->id }}" class="form-select" aria-label="Default select example" style="height:45px"  name="region_id">
                            <option value="{{ $dzongkhag->region_id }}" >Select Region</option>
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
            <button type="submit" class="btn btn-primary">Add Dzongkhag</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </form>
</div>
<!-- End Edit Dzongkhag -->

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
<!-- Add dzongkhag-->
<div id="add_dzongkhag" class="modal custom-modal fade" role="dialog">
    <form method="POST" action="{{route('dzongkhag.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Dzongkhag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Code<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="code" name="code"  required>
                                @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-form-label">Dzongkhag Name<span class="text-danger">*</span></label>
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
                            <option selected disabled>Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                            </select>
                      
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="region_id form-select-md">Region</label>
                            <select id="region_id" name="region_id" class="form-select" aria-label="Default select example" style="height:45px" >
                                    <!-- Populate this dropdown with available regions -->
                                    <option selected disabled>Select Region</option>
                                    <!-- Options will be populated dynamically using JavaScript -->
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
            <button type="submit" class="btn btn-primary">Add Dzongkhag</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </form>
</div>
<!-- End Add Region -->
				
</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    // Add an event listener to the country select input
    document.getElementById('country_id').addEventListener('change', function () {
        // Get the selected country's ID
        const selectedCountryId = this.value;
        console.log('id', selectedCountryId);

        // Make an AJAX request to fetch regions associated with the selected country
        fetch(`/get-regions/${selectedCountryId}`)
            .then(response => response.json())
            .then(data => {
                // Get the region select input element
                const regionSelect = document.getElementById('region_id');

                // Clear existing options
                regionSelect.innerHTML = '';

                // Add the default "Select Region" option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Select Region';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                regionSelect.appendChild(defaultOption);

                // Populate the region dropdown with fetched regions
                data.forEach(region => {
                    const option = document.createElement('option');
                    option.value = region.id;
                    option.text = region.name;
                    regionSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching regions:', error);
            });
    });
</script>

@if(isset($dzongkhag))
    <script>
        document.getElementById('country_id_{{ $dzongkhag->id }}').addEventListener('change', function () {
            // Get the selected country's ID
            const selectedCountryId = this.value;
            console.log('id', selectedCountryId);

            // Make an AJAX request to fetch regions associated with the selected country
            fetch(`/get-regions/${selectedCountryId}`)
                .then(response => response.json())
                .then(data => {
                    // Get the region select input element
                    const regionSelect = document.getElementById('region_id_{{ $dzongkhag->id }}');

                    // Clear existing options
                    regionSelect.innerHTML = '';

                    // Add the default "Select Region" option
                    const defaultOption = document.createElement('option');
                    defaultOption.text = 'Select Region';
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    regionSelect.appendChild(defaultOption);

                    // Populate the region dropdown with fetched regions
                    data.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.id;
                        option.text = region.name;
                        regionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching regions:', error);
                });
        });
    </script>
@endif



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