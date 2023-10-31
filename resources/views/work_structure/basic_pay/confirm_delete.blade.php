@extends('layout')
@section('content')
    <div class="container">
        <h2>Delete Basic Pay</h2>

        <p>Are you sure you want to delete the basic pay record?</p>

        <form method="POST" action="{{ route('basic_pay.destroy', ['basicPay' => $basicPay->id]) }}">
            @csrf
            @method('DELETE') <!-- Use the DELETE method for deletion -->

            <button type="submit" class="btn btn-danger">Delete Basic Pay</button>
            <a href="{{ route('basic_pay.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
