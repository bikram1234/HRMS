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
                <th>Employee</th>
                <th>number_of_days</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($appliedencashments as $appliedencashment)
                <tr>
                    <td>{{ $appliedencashment->user->name }}</td>
                    <td>{{ $appliedencashment->number_of_days }}</td>
                    <td>{{ $appliedencashment->amount }}</td>
                    <td class="@if ($appliedencashment->status === 'approved') bg-success text-white
                        @elseif ($appliedencashment->status === 'pending') bg-warning
                        @elseif ($appliedencashment->status === 'declined') bg-danger text-white
                        @else text-muted
                    @endif">
                        {{ $appliedencashment->status }}
                    </td>

                @if($appliedencashment->status === 'pending')
                    <td>
                        <a type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptleave{{ $appliedencashment->id}}">Accept</a>
                        </td>
                <div class="modal" id="acceptleave{{ $appliedencashment->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Approval</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('encashment.approve', ['id' => $appliedencashment->id]) }}">
                                @csrf
                            <h4>Are you sure you want to approve this Encashment?</h4>

                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Approve Now</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>


                <td class="mr-">
                <a type="button"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#declineleave{{ $appliedencashment->id}}">Decline</a> 
                </td>
                <div class="modal" id="declineleave{{ $appliedencashment->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <span class="modal-title">Leave Delcine</span>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form method="POST" action="{{ route('encashment.decline', ['id' => $appliedencashment->id]) }}">
                                @csrf
                            <h4>Are you sure you want to decline this leave?</h4>
                            <label for="remark">Remark</label>
                            <textarea name="remark" id="" cols="30" rows="4" class="form-control"></textarea>
                        <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Decline Now</button>
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
