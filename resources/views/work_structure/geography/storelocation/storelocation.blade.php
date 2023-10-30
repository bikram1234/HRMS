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
        <a href="">storelocation</a>
        <a href="">storelocation</a>
        <a href="">SoreLocation</a>
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">
        Add storelocation
    </button>

<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add storelocation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('storelocation.store') }}" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <label for="name">Store Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="dzongkhag_id">Dzongkhag</label>
                                <select id="dzongkhag_id" name="dzongkhag_id" class="form-control">
                                    <!-- Populate this dropdown with available countries -->
                                    <option selected disabled>Select Dzongkhag</option>
                                    @foreach($dzongkhags as $dzongkhag)
                                        <option value="{{ $dzongkhag->id }}">{{ $dzongkhag->name }}</option>
                                    @endforeach
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="timezone_id">Dzongkhag</label>
                                <select id="timezone_id" name="timezone_id" class="form-control">
                                    <!-- Populate this dropdown with available countries -->
                                    <option selected disabled>Select Timezone</option>
                                    @foreach($timezones as $timezone)
                                        <option value="{{ $timezone->id }}">{{ $timezone->name }}</option>
                                    @endforeach
                                    <!-- Add more options as needed -->
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
                    <th>Store Name</th>
                    <th>Dzongkhag</th>
                    <th>Region</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($storelocations->count() > 0)
                @foreach($storelocations as $storelocation)
                    <tr>
                        <td>1</td>
                        <td>{{ $storelocation->name }}</td>
                        <td>{{ $storelocation->dzongkhag->name }}</td>
                        <td>{{ $storelocation->dzongkhag->region->name }}</td>
                        <td>{{ $storelocation->dzongkhag->country->name }}</td>
                        @if($storelocation->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a data-toggle="modal" data-target="#myModal{{$storelocation->id}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('storelocation.delete', $storelocation->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</button>
                            </form>
                        </td>

                        <div class="modal" id="myModal{{$storelocation->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">storelocation Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form method="POST" action="{{  route('storelocation.update', $storelocation->id) }}" enctype="multipart/form-data">
                                                @csrf 
                                                    @method('patch')
                                                                
                                                <div class="form-group">
                                                <label for="name">Store Name</label>
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $storelocation->name }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="dzongkhag_id">Dzongkhag</label>
                                                <select id="dzongkhag_id" name="dzongkhag_id" class="form-control">
                                                    <!-- Populate this dropdown with available countries -->
                                                    <option value="{{ $storelocation->dzongkhag_id }}" >Select Dzongkhag</option>
                                                    @foreach($dzongkhags as $dzongkhag)
                                                        <option value="{{ $dzongkhag->id }}">{{ $dzongkhag->name }}</option>
                                                    @endforeach
                                                    <!-- Add more options as needed -->
                                                </select>
                                                @error('dzongkhag_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="timezone_id">Dzongkhag</label>
                                                <select id="timezone_id" name="timezone_id" class="form-control">
                                                    <!-- Populate this dropdown with available countries -->
                                                    <option value="{{ $storelocation->timezone_id }}" >Select Timezone</option>
                                                    @foreach($timezones as $timezone)
                                                        <option value="{{ $timezone->id }}">{{ $timezone->name }}</option>
                                                    @endforeach
                                                    <!-- Add more options as needed -->
                                                </select>
                                                @error('timezone_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status:</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="{{ $storelocation->status }}">Choose status:</option>
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

@endsection