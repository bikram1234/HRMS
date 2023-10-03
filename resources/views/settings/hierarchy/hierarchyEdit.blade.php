@extends('layout')
@section('content')

<div class="container mt-5">
        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <form method="POST" action="{{ route('hierarchy.update', $hierarchy->id) }}">
        @csrf
        @method('patch') 

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $hierarchy->name) }}">
        </div>

        <div class="form-group mt-3">
        <select class="form-control" id="level" name="level">
            <option value="{{ $hierarchy->level }}">Select Level:</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
            </select>
        </div>

        <div class="form-group mt-3">
        <select class="form-control" id="value" name="value">
            <option value="{{ $hierarchy->value }}">Select Value:</option>
                <option value="IS">Immediate Supervisor</option>
                <option value="SH">Section Head</option>
                <option value="DH">Department Head</option>
                <option value="MM">Management</option>
                <option value="HR">Human Resource</option>
                <option value="FH">Finance Head</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $hierarchy->start_date) }}">
        </div>

        <div class="form-group mt-3">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $hierarchy->end_date) }}">
        </div>

        <div class="form-group mt-3">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
            <option value="{{ $hierarchy->status }}">Select Status:</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
</div>

@endsection