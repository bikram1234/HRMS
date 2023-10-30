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
        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">
        Apply No Due
    </button>


    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Apply for No Due</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('nodue.create') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <textarea id="reason" name="reason" class="form-control" rows="3"></textarea>
                                @error('reason')
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
                    <th>Employee Name</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($requests->count() > 0)
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->reason }}</td>
                        <td class="@if ($request->status === 'approved') bg-success text-white
                            @elseif ($request->status === 'pending') bg-warning
                            @elseif ($request->status === 'declined') bg-danger text-white
                            @else bg-danger text-white
                        @endif">
                            {{ $request->status }}
                        </td>
                        @if($request->status === 'pending')
                        <td>
                        <a type="button"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelleave{{ $request->id}}">Cancel</a>
                        </td>
                        @endif
                        <div class="modal" id="cancelleave{{ $request->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Cancellation</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('leave.cancel', ['id' => $request->id]) }}">
                                @csrf
                            <h4>Are you sure you want to cancel this leave?</h4>

                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Cancel Now</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
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