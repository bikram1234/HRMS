<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Expense Application Form') }}</h2>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('submit-application') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Select Expense Type -->
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

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="application_date" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Application Date') }}
                            </label>
                            <input type="date" name="application_date" id="application_date"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ now()->format('Y-m-d') }}" readonly>
                        </div>

                        <!-- Total Amount -->
                        <div class="mb-4">
                            <label for="total_amount" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Total Amount') }}
                            </label>
                            <input type="number" name="total_amount" id="total_amount"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" min="0" value="{{ old('total_amount', 0) }}" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Description') }}
                            </label>
                            <textarea name="description" id="description"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Upload Attachment -->
                        <div class="mb-4">
                            <label for="attachment" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Upload Attachment (Max 2MB)') }}
                            </label>
                            <input type="file" name="attachment" id="attachment"
                                class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Submit Application') }}
                            </button>
                        </div>
                    </form>
                    <h2 class="text-lg font-semibold mt-6">{{ __('Your Details') }}</h2>

                    @if ($userApplications->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead>
                                <tr>
                                    <th>{{ __('Application Date') }}</th>
                                    <th>{{ __('Total Amount') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Attachment') }}</th>
                                    <th>{{ __('status') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userApplications as $userApplication)
                                    <tr>
                                        <td>{{ $userApplication->application_date }}</td>
                                        <td>${{ number_format($userApplication->total_amount, 2) }}</td>
                                        <td>{{ $userApplication->description }}</td>
                                        <td>
                                            @if ($userApplication->attachment)
                                                <a href="{{ asset('storage/'.$userApplication->attachment) }}" target="_blank">{{ $userApplication->attachment }}</a>
                                            @else
                                                {{ __('No attachment') }}
                                            @endif
                                        </td>
                                        <td class="text-center px-6 py-4 whitespace-nowrap" style="color:
                                        @if ($userApplication->status === 'pending')
                                            gray
                                        @elseif ($userApplication->status === 'approved')
                                            green
                                        @elseif ($userApplication->status === 'rejected')
                                            red
                                        @endif
                                    ">
                                        {{ ucfirst($userApplication->status) }}
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>{{ __('No application details available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
