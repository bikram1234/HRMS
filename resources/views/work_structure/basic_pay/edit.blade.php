@extends('layout')
@section('content')
    <div class="container">
        <h2>Edit Basic Pay</h2>

        <form method="POST" action="{{ route('basic_pay.update', ['basicPay' => $basicPay->id]) }}">
            @csrf
            @method('PUT') <!-- Use the PUT method for updating -->

            <div class="form-group">
                <label for="grade_id">Grade:</label>
                <select name="grade_id" id="grade_id" class="form-control" disabled>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ $basicPay->grade_id == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ $basicPay->amount }}" required>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Update Basic Pay</button>
        </form>
    </div>
@endsection
