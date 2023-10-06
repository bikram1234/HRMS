@extends('layout')  <!-- Extend your layout file -->

@section('content')
<div class="container">
    <h1>Edit Expense Type</h1>
    <form action="{{ route('expense-types.update', $expenseType->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $expenseType->name) }}">
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $expenseType->start_date) }}">
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $expenseType->end_date) }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="enforce" {{ $expenseType->status === 'enforce' ? 'selected' : '' }}>Enforce</option>
                <option value="draft" {{ $expenseType->status === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <br><br>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
