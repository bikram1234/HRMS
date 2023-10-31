@extends('layout')

@section('content')
    <h1>Create Device</h1>

    <!-- Create form -->
    <form action="{{ route('device.store') }}" method="POST">
        @csrf
        <input type="text" name="type" placeholder="Type">
        <input type="number" name="amount" placeholder="Amount">
        <button type="submit">Submit</button>
    </form>
@endsection