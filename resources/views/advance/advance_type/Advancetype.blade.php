<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Advance Type Form') }}</h2>

                    @if(session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('add-advance') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" {{ old('name') }} class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="expense_type_id" class="block font-medium text-sm text-gray-700">{{ __('Expense Type (optional)') }}</label>
                            <select name="expense_type_id" id="expense_type_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select an expense type</option>
                                @foreach ($expenseTypes as $expenseType)
                                    <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2" value="{{ old('start_date') }}" >
                                {{ __('Start Date') }}
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2" value="{{ old('end_date') }}" >
                                {{ __('End Date') }}
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Status') }}
                            </label>
                            <select name="status" id="status"
                                class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                    {{ __('Draft') }}
                                </option>
                                <option value="enforce" {{ old('status') === 'enforce' ? 'selected' : '' }}>
                                    {{ __('Enforce') }}
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Add Advance') }}
                            </button>
                        </div>
                        
                    </form>

                    <h2 class="text-lg font-semibold mt-6">{{ __('Advance Types List') }}</h2>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Expense Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('End Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($advances as $advance)
                            <tr id="advance-{{ $advance->id }}">
                                   <td class="px-6 py-4 whitespace-nowrap">{{  $advance->name }}</td>
                                   <td class="px-6 py-4 whitespace-nowrap">{{  $advance->expense_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $advance->start_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $advance->end_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap" style="color: {{ $advance->status === 'draft' ? 'gray' : 'green' }}">
                                        {{ $advance->status }}
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

