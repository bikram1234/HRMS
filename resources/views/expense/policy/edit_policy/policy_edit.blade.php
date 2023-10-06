<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Policy Enforcement') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
              <h1>Edit Policy</h1>
    <form method="POST" action="{{ route('update-policy', ['policy' => $policy->id]) }}">
        @csrf
        @method('PUT')
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <!-- Display the fields that should not be modified -->
        <div class="form-group">
            <label for="expense_type">Expense Type:</label>
            <input type="text" id="expense_type" value="{{ $policy->expenseType->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" value="{{ $policy->name }}" readonly>
        </div>

        <!-- Display the fields that can be edited -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description', $policy->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $policy->start_date) }}" readonly>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $policy->end_date) }}">
        </div>

        <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 1rem; border-radius: 0.25rem; cursor: pointer;">
            Save</button>
        
        <!-- Add a "Cancel" button that redirects back to the edit page with the existing data -->
        <a href="{{ route('edit-policy', ['policy' => $policy->id]) }}" style="background-color: #dc5b34; color: white; font-weight: bold; padding: 0.1rem 1rem; border-radius: 0.25rem; cursor: pointer;" class="btn btn-secondary" >Cancel</a>
    </form>
</div>
</x-app-layout>