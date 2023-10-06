<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Policy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Policy Form') }}</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('add-policy') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="expense_type_id" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Select Expense Type') }}
                            </label>
                            <select name="expense_type_id" id="expense_type_id"
                                class="form-select rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($expenseTypes as $expenseType)
                                    <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Policy Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Description') }}
                            </label>
                            <textarea name="description" id="description" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Start Date') }}
                            </label>
                            <input type="date" name="start_date" id="start_date" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('End Date') }}
                            </label>
                            <input type="date" name="end_date" id="end_date" class="form-input rounded-md shadow-sm mt-1 block w-full" >
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Status') }}
                            </label>
                            <select name="status" id="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="enforce" {{ old('status') === 'enforce' ? 'selected' : '' }}>Enforce</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Add Policy') }}
                            </button>
                        </div>
                    </form>

                    <h2 class="text-lg font-semibold mt-6">{{ __('Policy List') }}</h2>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Expense Type</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($policies as $policy)
                                <tr>
                                    <td>{{ $policy->name }}</td>
                                    <td>{{ $policy->expenseType->name }}</td>
                                    <td>{{ $policy->description }}</td>
                                    <td>{{ $policy->start_date }}</td>
                                    <td>{{ $policy->end_date }}</td>
                                    <td>{{ $policy->status }}</td>
                                    <td>
                                        <a href="{{ route('edit-policy', ['policy' => $policy->id]) }}" style="text-decoration: none;">
                                            <button type="button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 0.5rem; border-radius: 0.25rem; cursor: pointer;">
                                                {{ __('Edit') }}
                                            </button>
                                        </a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
