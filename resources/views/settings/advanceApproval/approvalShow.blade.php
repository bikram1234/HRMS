@extends('layout')
@section('content')

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
<div class="container mt-5">
    <form method="POST" action="{{ route('advance-approval.update', $approvalRule->id) }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="for">For:</label>
            <select name="For" id="for" class="form-control">
                <option disabled selected value="{{ $approvalRule->For}}">{{ $approvalRule->For}}</option>
                <option value="Leave">Leave</option>
                <option value="Expense">Expense</option>
                <option value="Loan">Loan</option>
            </select>
            @error('For')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="Type" id="type" class="form-control">
                <option {{ $approvalRule->For === 'Expense' ? 'readonly' : '' }}>
                    {{ $approvalRule->For === 'Expense' ? $approvalRule->types->name : $approvalRule->type->name }}
                </option>
                            </select>
            @error('Type')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">RuleName</label>
            <input type="text" name="RuleName" id="name" value="{{ $approvalRule->RuleName }}" class="form-control" >
            @error('RuleName')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ $approvalRule->start_date }}" class="form-control" >
            @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ $approvalRule->end_date }}" class="form-control" >
            @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="{{ $approvalRule->status}}">Choose status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>

        <a href="{{ route('advance-condition.create', ['approval_rule_id' => $approvalRule->id]) }}" class="btn btn-primary mt-3">ADD Condition</a>
    </form>

    <table class="table">
            <thead>
            <tr>
                <th>Formula</th>
                <th>Hierarchy Name</th>
                <th>Single User</th>
                <th>Auto Approval</th>
                <th>Action</th>
        </tr>
        </thead>
<tbody>
        @foreach ($specificConditions as $approval_condition)
            <tr>
            @if (count($formulas) > 0)
            <td>
                @foreach ($formulas as $collection)
                    @foreach ($collection as $formula)
                        {{ $formula->condition }}{{ $formula->field }} {{ $formula->operator }} @if($formula->value) {{ $formula->value }} @else {{ $formula->employee->name}} @endif
                    @endforeach
                @endforeach
            </td>


            @else
                <td>No formulas available.</td>
            @endif

                @if ($approval_condition->approval_type === 'Hierarchy')
                    <td>{{ $approval_condition->hierarchy->name }}</td>
                    <td>No</td>
                    <td>No</td>
                @elseif ($approval_condition->approval_type === 'Single User')
                    <td>No</td>
                    <td>{{ $approval_condition->employee_id }}</td>
                    <td>No</td>
                @elseif ($approval_condition->approval_type === 'Auto Approval')
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                @endif
                <td>    
                <a href="{{ route('formula.createForApprovalCondition', $approval_condition->id)}}" class="btn btn-primary btn-sm">Add Formula</a>
                <a href="{{ route('advance-approval_condition.edit', $approval_condition->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td> <!-- Action column, you can add actions here -->
            </tr>
        @endforeach

            </tbody>
    </table>

</div>



@endsection