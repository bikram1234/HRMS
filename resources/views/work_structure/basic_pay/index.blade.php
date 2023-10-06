@extends('layout')
@section('content')
    <div class="container">
        <h2>Basic Pay Records</h2>

        <a href="{{ route('basic_pay.create') }}" class="btn btn-primary mb-3">Add Basic Pay</a>

        @if(count($basicPays) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Grade</th>
                        <th>Basic Pay</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($basicPays as $basicPay)
                        <tr>
                            <td>{{ $basicPay->grade->name }}</td>
                            <td>{{ $basicPay->amount }}</td>
                            <td>
                                <a href="{{ route('basic_pay.edit', ['basicPay' => $basicPay->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('basic_pay.confirm_delete', ['basicPay' => $basicPay->id]) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No basic pay records found.</p>
        @endif
    </div>
    @endsection