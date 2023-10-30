@extends('layout')  <!-- Extend your layout file -->

@section('content')
<div class="container">
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
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->noDueRequest->user->name }}</td>
                    <td>{{ $request->noDueRequest->reason }}</td>
                    <td class="@if ($request->status === 'approved') bg-success text-white
                        @elseif ($request->status === 'pending') bg-warning
                        @elseif ($request->status === 'declined') bg-danger text-white
                        @else text-muted
                    @endif">
                        {{ $request->status }}
                    </td>

                @if($request->status === 'pending')
                    <td>
                        <a type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $request->id}}">Accept</a>
                        </td>
                <div class="modal" id="acceptleave{{ $request->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="GET" action="{{ route('nodue.approve', ['id' => $request->id]) }}">
                                @csrf
                            <h4>Are you sure you want to approve this leave?</h4>

                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Approve Now</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>


                <td class="mr-">
                <a type="button"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#declineleave{{ $request->id}}">Decline</a> 
                </td>
                <div class="modal" id="declineleave{{ $request->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Delcine</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('leave.decline', ['id' => $request->id]) }}">
                                @csrf
                            <h4>Are you sure you want to decline this leave?</h4>

                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Approve Now</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

                        
                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


@endsection
