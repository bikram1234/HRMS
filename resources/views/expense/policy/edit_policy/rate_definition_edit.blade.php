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
              <h1>Edit Rate Definition</h1>
    <form method="POST" action="{{ route('update-rate-definition', ['policy' => $policy->id]) }}">
        @csrf
        @method('PUT')

        <!-- Display the fields that should not be modified -->
        <div class="form-group">
            {{-- <label for="policy_id">Policy ID:</label> --}}
            <input type="hidden" type="text" id="policy_id" value="{{ $policy->id }}" readonly>
        </div>

              <!-- Display the fields that should not be modified -->
        <!-- For example, you can display the existing options here -->
        <div class="form-group">
            <label for="attachment_required">Attachment Required:</label>
            <input type="checkbox" id="attachment_required" name="attachment_required" value="1" {{ $rateDefinition->attachment_required ? 'checked' : '' }} readonly>
        </div>

        <!-- Display the fields that can be edited -->
        <div class="form-group">
            <label for="travel_type">Travel Type:</label>
            <select id="travel_type" name="travel_type" @if($rateDefinition->travel_type) disabled @endif>
                <option value="domestic" {{ $rateDefinition->travel_type == 'domestic' ? 'selected' : '' }} readonly>Domestic</option>
                <!-- Add other options as needed -->
            </select>
        </div>
       <!-- Rate Currency Type -->
       <div class="mt-4">
        <label for="type" class="block font-medium text-sm text-gray-700">{{ __(' Type') }}</label>
        <select id="type" name="type" class="form-select rounded-md shadow-sm mt-1 block w-full">
            <option value="Single Currency"{{ $rateDefinition->type == 'Single Currency' ? 'selected' : '' }} readonly>Single Currency</option>
        </select>
    </div>

     <!-- Rate Currency Type -->
     <div class="mt-4">
        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
        <select id="name" name="name" class="form-select rounded-md shadow-sm mt-1 block w-full">
            <option value="Nu"{{ $rateDefinition->name == 'Nu' ? 'selected' : '' }} readonly>Nu</option>
        </select>
    </div>
        
        <div class="form-group">
            <label for="rate_limit">Rate Limit:</label>
            <select id="rate_limit" name="rate_limit" @if($rateDefinition->rate_limit) disabled @endif>
                <option value="daily" {{ $rateDefinition->rate_limit == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ $rateDefinition->rate_limit == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ $rateDefinition->rate_limit == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>

        @if ($rateLimits && count($rateLimits) > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th>Grade</th>
                    <th>Region</th>
                    <th>Limit Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
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
                    <td>
                        <a href="{{ route('edit-rate-limit', ['rateLimit' => $rateLimit->id]) }}" style="text-decoration: none;">
                            <button type="button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 0.5rem; border-radius: 0.25rem; cursor: pointer;">
                                {{ __('Edit') }}
                            </button>
                        </a>
                    </td>
                    

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

<button type="button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;" class="btn btn-primary" onclick="window.location.href='{{ route('edit-rate-limits.create', ['rateDefinition' => $rateDefinition->id]) }}'">Create limit</button>
<br><br>        
        <!-- Add a "Cancel" button that redirects back to the edit page with the existing data -->
        <button type="button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;" onclick="window.location.href='{{ route('edit-policy-enforcement', ['policy' => $policy->id]) }}'">
            {{ __('Save And Continue') }}
        </button>               
        <button type="button" style="background-color: #dc5b34; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;" class="btn btn-secondary" onclick="window.location.href='{{ route('edit-rate-definition', ['policy' => $policy->id]) }}'">
            Cancel
        </button>
            </form>
</div>
</x-app-layout>