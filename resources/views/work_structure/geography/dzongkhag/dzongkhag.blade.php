@extends('layout')

@section('content')

    <div class="container mt-5">
        
    @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

              
    @if(session('error'))
            <div id="error-message" class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        <a href="">Country</a>
        <a href="">TimeZone</a>
        <a href="">dzongkhag</a>
        <a href="">Dzongkhag</a>
        <a href="">SoreLocation</a>
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">
        Add dzongkhag
    </button>

<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Dzongkhag</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('dzongkhag.store') }}" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" id="code" name="code" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="name">dzongkhag Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select id="country_id" name="country_id" class="form-control">
                                    <!-- Populate this dropdown with available countries -->
                                    <option selected disabled>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="region_id">Region</label>
                                <select id="region_id" name="region_id" class="form-control">
                                    <!-- Populate this dropdown with available regions -->
                                    <option selected disabled>Select Region</option>
                                    <!-- Options will be populated dynamically using JavaScript -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option disabled selected>Choose status:</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                </form>
            </div>
        </div>
</div>

        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Code</th>
                    <th>Dzongkhag Name</th>
                    <th>Region</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($dzongkhags->count() > 0)
                @foreach($dzongkhags as $dzongkhag)
                    <tr>
                        <td>1</td>
                        <td>{{ $dzongkhag->code }}</td>
                        <td>{{ $dzongkhag->name }}</td>
                        <td>{{ $dzongkhag->region->name }}</td>
                        <td>{{ $dzongkhag->country->name }}</td>
                        @if($dzongkhag->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a data-toggle="modal" data-target="#myModal{{$dzongkhag->id}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('dzongkhag.delete', $dzongkhag->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</button>
                            </form>
                        </td>

                        <div class="modal" id="myModal{{$dzongkhag->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">dzongkhag Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('dzongkhag.update', $dzongkhag->id) }}" enctype="multipart/form-data">
                                                @csrf 
                                                    @method('patch')
                                                                
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" id="code" name="code" class="form-control" value="{{ $dzongkhag->code }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Dzongkhag Name</label>
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $dzongkhag->name }}" required>
                                            </div>

                                        <div class="form-group">
                                            <label for="country_id">Country</label>
                                            <select id="country_id_{{ $dzongkhag->id }}" name="country_id" class="form-control">
                                                <!-- Populate this dropdown with available countries -->
                                                <option value="{{ $dzongkhag->country_id}}" >Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>

                                    <div class="form-group">
                                        <label for="region_id">Region</label>
                                        <select id="region_id_{{ $dzongkhag->id }}" name="region_id" class="form-control">
                                            <!-- Populate this dropdown with available regions -->
                                            <option value="{{ $dzongkhag->region_id }}" >Select Region</option>
                                            <!-- Options will be populated dynamically using JavaScript -->
                                        </select>
                                    </div>

                                            <div class="form-group">
                                                <label for="status">Status:</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="{{ $dzongkhag->status }}">Choose status:</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                            </div>

                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </tr>
                @endforeach
                @else
                <h1>No datas</h1>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

    <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>

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
@endsection