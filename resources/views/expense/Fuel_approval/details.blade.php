@extends('layout')

@section('content')
    <h1 style="font-weight: inherit">Fuel Details</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Username:</div>
                    <div class="">{{ $fuel->user->name }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Expense Type:</div>
                    <div class="">{{ $fuel->expenseType->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Application Date:</div>
                    <div class="">{{ $fuel->date }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Location:</div>
                    <div class="">{{ $fuel->location }}</div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">vechicle Type:</div>
                        <div class="">{{ $fuel->vehicle_type }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Vehicle Number:</div>
                        <div class="">{{ $fuel->vehicle_no }}</div>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Attachment:</div>
                        <div class="">{{ $fuel->attachment }}</div>
                    </div>
                </div>
            </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Intial KM:</div>
                        <div class="">{{ $fuel->initial_km }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Final KM:</div>
                        <div class="">{{ $fuel->final_km }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Quantity:</div>
                        <div class="">{{ $fuel->quantity }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Mileage:</div>
                        <div class="">{{ $fuel->mileage }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Rate:</div>
                        <div class="">{{ $fuel->rate }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Amount:</div>
                        <div class="">{{ $fuel->amount }}</div>
                    </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Status:</div>
                    <div class="">{{ $fuel->status }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Remark:</div>
                    <div class="">{{ $fuel->remark }}</div>
                </div>
            </div>                   
    </div>
@endsection
