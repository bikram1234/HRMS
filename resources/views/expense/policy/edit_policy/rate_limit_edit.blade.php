<div class="container mx-auto">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Rate Limit') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                      <h1>Edit Rate Limit</h1>
    <form method="POST" action="{{ route('update-rate-limit', ['rateLimit' => $rateLimit->id]) }}">
        @csrf
        @method('PUT')

        <!-- Display the fields that should not be modified -->
        <div class="form-group">
            <label for="grade">Grade:</label>
            <input type="text" id="grade" value="{{ $rateLimit->grade }}" readonly>
        </div>
        <div class="form-group">
            <label for="region">Region:</label>
            <input type="text" id="region" value="{{ $rateLimit->region }}" readonly>
        </div>

        <!-- Display the fields that can be edited -->
        <div class="form-group">
            <label for="limit_amount">Limit Amount:</label>
            <input type="number" id="limit_amount" name="limit_amount" value="{{ old('limit_amount', $rateLimit->limit_amount) }}" @if($rateLimit->limit_amount) readonly @endif>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $rateLimit->start_date) }}" @if($rateLimit->start_date) readonly @endif>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $rateLimit->end_date) }}" @if($rateLimit->end_date) readonly @endif>
            @error('end_date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" @if($rateLimit->status) disabled @endif>
                <option value="active" {{ $rateLimit->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $rateLimit->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;"class="btn btn-primary">Save</button>
        
        <!-- Add a "Cancel" button that redirects back to the edit page with the existing data -->
        <a style="background-color: #d84319; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;" href="{{ route('edit-rate-limit', ['rateLimit' => $rateLimit->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
    </x-app-layout>
</div>