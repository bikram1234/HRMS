@extends('layout')

@section('content')
    <h1>Edit Device</h1>

    <!-- Edit form -->
    <form action="{{ route('device.update', $device) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="type" value="{{ $device->type }}">
        <input type="number" name="amount" value="{{ $device->amount }}">
        <button type="submit">Update</button>
    </form>
@endsection