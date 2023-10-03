<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Section') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Add Section Form') }}</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('add-section') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Select Department') }}
                            </label>
                            <select name="department_id" id="department_id" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Section Name') }}
                            </label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('name') }}" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Add Section') }}
                            </button>
                        </div>
                    </form>

                    <h2 class="text-lg font-semibold mt-6">{{ __('Sections') }}</h2>

                    @if ($sections->isEmpty())
                        <p>{{ __('No sections available.') }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Section Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Department') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sections as $section)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $section->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $section->department->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $sections->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
