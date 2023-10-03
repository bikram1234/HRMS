<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Expense Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Expense Type Form') }}</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('expense-types') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Start Date') }}
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">
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
                                <option value="enforce" {{ old('status') === 'enforce' ? 'selected' : '' }}>
                                    {{ __('Enforce') }}
                                </option>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                    {{ __('draft') }}
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Add Expense Type') }}
                            </button>
                        </div>
                        
                    </form>

                    <h2 class="text-lg font-semibold mt-6">{{ __('Expense Types List') }}</h2>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('End Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($expenseTypes as $expenseType)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expenseType->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expenseType->start_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expenseType->end_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap" style="color: {{ $expenseType->status === 'enforce' ? 'green' : 'gray' }}">
                                        {{ $expenseType->status }}
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
