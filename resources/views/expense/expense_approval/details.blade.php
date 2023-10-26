@extends('layout')

@section('content')
    <h1 style="font-weight: inherit">Expense Details</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Username:</div>
                    <div class="">{{ $expense->user->name }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6"style="font-weight: bolder">Expense Type:</div>
                    <div class="">{{ $expense->expenseType->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Application Date:</div>
                    <div class="">{{ $expense->application_date }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Description:</div>
                    <div class="">{{ $expense->description }}</div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Total Amount:</div>
                        <div class="">{{ $expense->total_amount }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Attachment:</div>
                        <div class="">{{ $expense->attachment }}</div>
                    </div>
                </div>
            </div>

                @if($expense->expenseType->name == 'Conveyance Expense')
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6" style="font-weight: bolder">Travel Type:</div>
                        <div class="">{{ $expense->travel_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Travel Mode:</div>
                        <div class="">{{ $expense->travel_mode }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Travel From Date:</div>
                        <div class="">{{ $expense->travel_from_date }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Travel From:</div>
                        <div class="">{{ $expense->travel_from }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Travel To Date:</div>
                        <div class="">{{ $expense->travel_to_date }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"style="font-weight: bolder">Travel To:</div>
                        <div class="">{{ $expense->travel_to }}</div>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Status:</div>
                    <div class="">{{ $expense->status }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"style="font-weight: bolder">Remark:</div>
                    <div class="">{{ $expense->remark }}</div>
                </div>
            </div>                   
    </div>
@endsection
