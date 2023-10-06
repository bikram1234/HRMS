@extends('layout')
@section('content')
    <div class="container">
        <h2>Add Basic Pay</h2>

        <form method="POST" action="{{ route('basic_pay.store') }}">
            @csrf
            @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
         @endif
            <div class="form-group">
                <label for="grade_id">Select Grade:</label>
                <select name="grade_id" id="grade_id" class="form-control">
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Add Basic Pay</button>
        </form>
    </div>
@endsection
