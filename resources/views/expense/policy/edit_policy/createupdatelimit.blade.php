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
                        @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('new-rate-limits.store', ['rateDefinition' => $rateDefinition->id]) }}">
                            @csrf

                            <!-- Grade -->
                            <div class="mt-4">
                                <label for="grade" class="block font-medium text-sm text-gray-700">{{ __('Grade') }}</label>
                                <div class="mt-2">
                                    <button id="toggle-grades" type="button" class="bg-blue-500 text-black py-2 px-4 rounded-full">Select Grade</button>
                                </div>
                                <div id="grade-checkboxes" style="display: none;">
                                    @foreach ($grades as $grade)
                                        <label class="block mt-1">
                                            <input type="checkbox" name="grade[]" value="{{ $grade->id }}" class="mr-2">{{ $grade->name }}
                                        </label>
                                    @endforeach
                                    @error('grade')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                </div>
                            </div>
                            
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('#toggle-grades').click(function () {
                                        $('#grade-checkboxes').toggle();
                                    });
                                });
                            </script>
                            

                            <!-- Region -->
                            <div class="mt-4">
                                <label for="region" class="block font-medium text-sm text-gray-700">{{ __('Region') }}</label>
                                <select id="region" name="region" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="Bumthang">Bumthang</option>
                                    <option value="Gelephu">Gelephu</option>
                                    <option value="Mongar">Mongar</option>
                                    <option value="Paro">Paro</option>
                                    <option value="Phuntsholing">Phuntsholing</option>
                                    <option value="Punakha">Punakha</option>
                                    <option value="Sumdrup Jongkhar">Sumdrup Jongkhar</option>
                                    <option value="Samtse">Samtse</option>
                                    <option value="Thimphu">Thimphu</option>
                                    <option value="Trashigang">Trashigang</option>
                                    <option value="Tsirang">Tsirang</option>
                                </select>                                </div>

                            <!-- Limit Amount -->
                            <div class="mt-4">
                                <label for="limit_amount" class="block font-medium text-sm text-gray-700">{{ __('Limit Amount') }}</label>
                                <input id="limit_amount" type="number" class="form-input rounded-md shadow-sm mt-1 block w-full" name="limit_amount" required />
                            </div>

                            <!-- Start Date -->
                            <div class="mt-4">
                                <label for="start_date" class="block font-medium text-sm text-gray-700">{{ __('Start Date') }}</label>
                                <input id="start_date" type="date" class="form-input rounded-md shadow-sm mt-1 block w-full" name="start_date" required />
                            </div>

                            <!-- End Date -->
                            <div class="mt-4">
                                <label for="end_date" class="block font-medium text-sm text-gray-700">{{ __('End Date') }}</label>
                                <input id="end_date" type="date" class="form-input rounded-md shadow-sm mt-1 block w-full" name="end_date" />
                                @error('end_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>

                            <!-- Status -->
                            <div class="mt-4">
                                <label for="status" class="block font-medium text-sm text-gray-700">{{ __('Status') }}</label>
                                <select id="status" name="status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="mt-6">
                                <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;"class="btn btn-primary">
                                    {{ __('Create Rate Limit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
