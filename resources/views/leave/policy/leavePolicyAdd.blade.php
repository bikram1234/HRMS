@extends('layout')

@section('content')

        
@if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('leavepolicy.store') }}">
        @csrf

        <div class="form-group" id="hierarchyFields">
            <label for="leave_id">Leave Type:</label>
            <select name="leave_id" id="leave_id" class="form-control">
                <option disabled selected>Select LeaveType</option>
                @foreach($leavetypes as $leavetype)
                <option value="{{ $leavetype->id }}">{{ $leavetype->name }}</option>
                @endforeach
            </select>
            @error('leave_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="policy_name">Policy Name:</label>
            <input type="text" class="form-control" id="policy_name" name="policy_name">
            @error('policy_name')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
                <label for="policy_description">Policy Description:</label>
                <textarea class="form-control" id="policy_description" name="policy_description"></textarea>
            @error('policy_description')
                 <small class="text-danger">{{ $message }}</small>
            @enderror
         </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" >
            @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" >
            @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
                <option disabled selected>Choose status:</option>
                <option value="1">Enforce</option>
                <option value="0">Draft</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <div class="form-group">
                <label for="is_information_only">Is Information Only:</label>
                <input type="checkbox" id="is_information_only" name="is_information_only">
                @error('is_information_only')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        <button type="submit" class="btn btn-primary mt-4">Add Policy</button>
    </form>
</div>

@endsection