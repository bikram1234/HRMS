@extends('layout')

@section('content')
    <h1 style="font-weight: inherit">Transfer Details</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Username:</div>
                    <div class="">{{ $transfer->user->name }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Expense Type:</div>
                    <div class="">{{ $transfer->expenseType->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Designation:</div>
                    <div class="">{{ $transfer->designation }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Department:</div>
                    <div class="">{{ $transfer->department }}</div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Basic_pay:</div>
                        <div class="">{{ $transfer->basic_pay }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Transfer Claim Type:</div>
                        <div class="">{{ $transfer->transfer_claim_type }}</div>
                    </div>
                </div>
            </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Current Location:</div>
                        <div class="">{{ $transfer->current_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">New Location:</div>
                        <div class="">{{ $transfer->new_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Claim Amount:</div>
                        <div class="">{{ $transfer->claim_amount }}</div>
                    </div>
                    @if($transfer->transfer_claim_type == 'Carriage Charge')
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Distance (KM):</div>
                        <div class="">{{ $transfer->distance_km }}</div>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Status:</div>
                    <div class="">{{ $transfer->status }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Attachment:</div>
                    <div class="">{{ $transfer->attachment }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Remark:</div>
                    <div class="">{{ $transfer->remark }}</div>
                </div>
            </div>                   
    </div>
@endsection
