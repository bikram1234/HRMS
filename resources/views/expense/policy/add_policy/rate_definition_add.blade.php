
<div class="container mx-auto">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Rate Definition') }}
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
                        <form method="POST" action="{{ route('store-rate-definition') }}">
                            @csrf

                            <!-- Policy ID -->
                            <div class="mt-4">
                                {{-- <label type="hidden" for="policy_id" class="block font-medium text-sm text-gray-700">{{ __('Policy ID') }}</label> --}}
                                <input type="hidden" id="policy_id" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full" name="policy_id" value="{{ $policy->id }}" readonly />
                            </div>

                            <!-- Attachment Required -->
                            <div class="mt-4">
                                <label for="attachment_required" class="block font-medium text-sm text-gray-700">{{ __('Attachment Required') }}</label>
                                <select id="attachment_required" name="attachment_required" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Travel Type -->
                            <div class="mt-4">
                                <label for="travel_type" class="block font-medium text-sm text-gray-700">{{ __('Travel Type') }}</label>
                                <select id="travel_type" name="travel_type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="domestic">Domestic</option>
                                </select>
                            </div>
                            
                              <!-- Rate Currency Type -->
                              <div class="mt-4">
                                <label for="type" class="block font-medium text-sm text-gray-700">{{ __(' Type') }}</label>
                                <select id="type" name="type" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="Single Currency">Single Currency</option>
                                </select>
                            </div>

                             <!-- Rate Currency Type -->
                             <div class="mt-4">
                                <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                                <select id="name" name="name" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="Nu">Nu</option>
                                </select>
                            </div>

                            <!-- Rate Limit -->
                            <div class="mt-4">
                                <label for="rate_limit" class="block font-medium text-sm text-gray-700">{{ __('Rate Limit') }}</label>
                                <select id="rate_limit" name="rate_limit" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="daily">Daily</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>

                            <div class="mt-6">
                                <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;"class="btn btn-primary">
                                    {{ __('Create Limit') }}
                                </button>
                            </div>
                        </form>            
                       @if ($rateLimits && count($rateLimits) > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th>Grade</th>
                                        <th>Region</th>
                                        <th>Limit Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rateLimits as $rateLimit)
                                    <tr>
                                        <td>{{ $rateLimit->gradeName->name }}</td>
                                        <td>{{ $rateLimit->region }}</td>
                                        <td>{{ $rateLimit->limit_amount }}</td>
                                        <td>{{ $rateLimit->start_date }}</td>
                                        <td>{{ $rateLimit->end_date }}</td>
                                        <td>{{ $rateLimit->status }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        <!-- Display pagination links -->
                        {{ $rateLimits->links() }}
                        @else
                            <p>No rate limits found for this policy.</p>
                        @endif    
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('policy-enforcement.index', ['policy' => $policy]) }}" style="text-decoration: none;">
                            <button type="button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Save And Submit') }}
                            </button>
                        </a>
                    </div>                                        
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
