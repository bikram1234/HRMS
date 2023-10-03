@extends('layout')

@section('content')

@if(session('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <form method="POST" action="{{ route('yearendprocessing.store') }}">

        @csrf
    <div class="form-group">
                <input type="hidden" id="leave_id" name="leave_id" value="{{ $leave_id }}">
                @error('leave_id')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="allow_carryover">Allow Carry Over:</label>
            <input type="checkbox" id="allow_carryover" name="allow_carryover" value="1">
            @error('allow_carryover')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="carryover_limit">Carry Over Limit:</label>
            <input type="number" id="carryover_limit" name="carryover_limit" class="form-control" value="0">
            @error('carryover_limit')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="payat_yearend">Pay at Year-End:</label>
            <input type="checkbox" id="payat_yearend" name="payat_yearend" value="1">
            @error('payat_yearend')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="min_balance">Minimum Balance:</label>
            <input type="number" id="min_balance" name="min_balance" class="form-control">
            @error('min_balance')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="max_balance">Maximum Balance:</label>
            <input type="number" id="max_balance" name="max_balance" class="form-control">
            @error('max_balance')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="carryforward_toEL">Carry Forward to EL:</label>
            <input type="checkbox" id="carryforward_toEL" name="carryforward_toEL" value="1">
            @error('carryforward_toEL')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="carryforward_toEL_limit">Carry Forward to EL Limit:</label>
            <input type="number" id="carryforward_toEL_limit" name="carryforward_toEL_limit" class="form-control">
            @error('carryforward_toEL_limit')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
</div>

@endsection
