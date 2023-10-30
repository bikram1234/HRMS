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
        <a href="{{ route('timezone.index') }}">TimeZone</a>
        <a href="{{ route('region.index') }}">Region</a>
        <a href="{{ route('dzongkhag.index') }}">Dzongkhag</a>
        <a href="{{ route('storelocation.index') }}">SoreLocation</a>
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">
        Add Country
    </button>

<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Apply for Leave</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('country.store') }}" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" id="code" name="code" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="name">Country Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
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
                    <th>Country Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($countries->count() > 0)
                @foreach($countries as $country)
                    <tr>
                        <td>1</td>
                        <td>{{ $country->code }}</td>
                        <td>{{ $country->name }}</td>
                        @if($country->status == 1 )
                         <td>Active</td>
                         @else
                         <td>Inactive</td>
                         @endif
                        <td>
                            <a data-toggle="modal" data-target="#myModal{{$country->id}}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('country.delete', $country->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</button>
                            </form>
                        </td>

                        <div class="modal" id="myModal{{$country->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Country Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('country.update', $country->id) }}" enctype="multipart/form-data">
                                                @csrf 
                                                    @method('patch')
                                                    <div class="form-group">
                                                        <label for="code">Code</label>
                                                        <input type="text" id="code" name="code" class="form-control" value="{{ $country->code }}" required>
                                                        @error('code')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Country Name</label>
                                                        <input type="text" id="name" name="name" class="form-control" value="{{ $country->name }}" required>
                                                        @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="{{ $country->status }}">Choose status:</option>
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