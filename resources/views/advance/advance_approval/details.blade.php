@extends('layout')

@section('content')
    <h1 style="font-weight: inherit">Advance/Loan/Emi Details</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Username:</div>
                    <div class="">{{ $advance->user->name }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Advance Type:</div>
                    <div class="">{{ $advance->advanceType->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Application Date:</div>
                    <div class="">{{ $advance->date }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Advance Number:</div>
                    <div class="">{{ $advance->advance_no }}</div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Amount:</div>
                        <div class="">{{ $advance->amount}}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Attachment:</div>
                        <div class="">{{ $advance->attachment }}</div>
                    </div>
                </div>
            </div>

                @if($advance->advanceType->name == 'DSA Advance' && 'Advance To Staff')
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Mode of Travel:</div>
                        <div class="">{{ $advance->mode_of_travel }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">From Location:</div>
                        <div class="">{{ $advance->from_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">From Date:</div>
                        <div class="">{{ $advance->from_date }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">T0 Location:</div>
                        <div class="">{{ $advance->to_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">To Date:</div>
                        <div class="">{{ $advance->to_date }}</div>
                    </div>
                @endif
                @if($advance->advanceType->name == 'Salary Advance')
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">EMI Count:</div>
                        <div class="">{{ $advance->emi_count }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Deduction Period:</div>
                        <div class="">{{ $advance->deduction_period }}</div>
                    </div>
                @endif
                @if($advance->advanceType->name == 'SIFA Loan')
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Interest Rate:</div>
                        <div class="">{{ $advance->interest_rate }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">:Total Amount</div>
                        <div class="">{{ $advance->total_amount }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">EMI Count:</div>
                        <div class="">{{ $advance->emi_count }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Monthly EMI Amount:</div>
                        <div class="">{{ $advance->monthly_emi_amount }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Deduction Period:</div>
                        <div class="">{{ $advance->deduction_period }}</div>
                    </div>
                @endif
                @if($advance->advanceType->name == 'Device EMI')
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Type:</div>
                        <div class="">{{ $advance->type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Interest Rate:</div>
                        <div class="">{{ $advance->interest_rate }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Total Amount:</div>
                        <div class="">{{ $advance->total_amount }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">EMI Count:</div>
                        <div class="">{{ $advance->emi_count }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Monthly EMI Amount:</div>
                        <div class="">{{ $advance->monthly_emi_amount }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Deduction Period:</div>
                        <div class="">{{ $advance->deduction_period }}</div>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Purpose:</div>
                    <div class="">{{ $advance->purpose }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Status:</div>
                    <div class="">{{ $advance->status }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Remark:</div>
                    <div class="">{{ $advance->remark }}</div>
                </div>
            </div>                   
    </div>
@endsection
