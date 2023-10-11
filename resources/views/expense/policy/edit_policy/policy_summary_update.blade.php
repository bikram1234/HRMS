<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Policy Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                    <!-- Policy Details -->
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-2">Policy Details</h3>
                        @if ($draftPolicy)
                        <ul>
                            <li><strong>Name:</strong> {{ $draftPolicy->name }}</li>
                            <li><strong>Description:</strong> {{ $draftPolicy->description }}</li>
                            <li><strong>Start Date:</strong> {{ $draftPolicy->start_date }}</li>
                            <li><strong>End Date:</strong> {{ $draftPolicy->end_date }}</li>
                            <li><strong>Status:</strong> {{ $draftPolicy->status }}</li>
                        </ul>
                        @else
                        <p>No draft data for the policy.</p>
                    @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-2">Rate Definitions</h3>
                        @if ($rateDefinitions->count() > 0)
                        <ul>
                            @foreach ($rateDefinitions as $rateDefinition)
                            <li>
                                <strong>Attachment:</strong> {{ $rateDefinition->attachment_required ? 'Yes' : 'No' }}
                            </li>
                            <li><strong>Travel Type:</strong> {{ $rateDefinition->travel_type }}</li>
                            <li><strong>Rate Currency(Type):</strong> {{ $rateDefinition->type }}</li>
                            <li><strong>Rate Currency(Name):</strong> {{ $rateDefinition->name }}</li>
                            <li><strong>Rate Limit:</strong> {{ $rateDefinition->rate_limit }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p>No Rate Definitions found.</p>
                        @endif
                    </div>
                    
                    <!-- Rate Limits Fields -->
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-2">Rate Limits</h3>
                        @if ($rateLimits->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Limit Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rateLimits as $rateLimit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->gradeName->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->region }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->limit_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->start_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->end_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $rateLimit->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No Rate Limits found.</p>
                        @endif
                    </div>

                    <!-- Policy Enforcement Fields -->
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-2">Policy Enforcement</h3>
                         <!-- Display draft policy enforcement details -->
                         <h3>Policy Enforcement Draft</h3>
                         @if ($draftPolicyEnforcement)
                         <ul>
                            <li>
                                Prevent Submission:
                                <input type="checkbox" {{ $draftPolicyEnforcement->prevent_submission ? 'checked' : '' }} disabled>
                            </li>
                            <li>
                                Display Warning:
                                <input type="checkbox" {{ $draftPolicyEnforcement->display_warning ? 'checked' : '' }} disabled>
                            </li>
                        </ul>
                        
                             <!-- Add more draft policy enforcement fields as needed -->
                         @else
                             <p>No draft data for policy enforcement.</p>
                         @endif
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="flex items-center justify-end mt-4">
                        <form method="post" action="{{ route('policy.summary.saveOrCancel', ['policy' => $policy->id]) }}">
                            @csrf
                            <button type="submit" name="cancel" class="bg-red-500 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                            <button type="submit" name="save" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



{{-- 
 <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Policy Summary') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Draft Summary</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                            <!-- Display draft policy details -->
                            <h3>Policy Draft</h3>
                            @if ($draftPolicy)
                                <!-- Display draft policy fields here -->
                                <ul>
                                    <li><strong>Name:</strong> {{ $draftPolicy->name }}</li>
                                    <li><strong>Description:</strong> {{ $draftPolicy->description }}</li>
                                    <li><strong>Start Date:</strong> {{ $draftPolicy->start_date }}</li>
                                    <li><strong>End Date:</strong> {{ $draftPolicy->end_date }}</li>
                                    <li><strong>Status:</strong> {{ $draftPolicy->status }}</li>
                                </ul>
                                <!-- Add more draft policy fields as needed -->
                            @else
                                <p>No draft data for the policy.</p>
                            @endif

                            <div class="mb-4">
                                <h3 class="text-xl font-semibold mb-2">Rate Definitions</h3>
                                @if ($rateDefinitions->count() > 0)
                                <ul>
                                    @foreach ($rateDefinitions as $rateDefinition)
                                    <li>
                                        <strong>Attachment:</strong> {{ $rateDefinition->attachment_required ? 'Yes' : 'No' }}
                                    </li>
                                    <li><strong>Travel Type:</strong> {{ $rateDefinition->travel_type }}</li>
                                    <li><strong>Rate Currency:</strong> {{ $rateDefinition->rate_currency }}</li>
                                    <li><strong>Rate Limit:</strong> {{ $rateDefinition->rate_limit }}</li>
                                    @endforeach
                                </ul>
                                @else
                                <p>No Rate Definitions found.</p>
                                @endif
                            </div>

                            <!-- Display draft rate limits details -->
                            <h3>Rate Limits Draft</h3>
                            @if ($draftRateLimits)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Limit Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($draftRateLimits as $draftRateLimit)
                                    <div class="form-group">
                                        <label for="draft_grade">Grade:</label>
                                        <input type="text" id="draft_grade" name="draft_grade[]" value="{{ $draftRateLimit['grade'] }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="draft_grade">Grade:</label>
                                        <input type="text" id="draft_grade" name="draft_grade[]" value="{{ $draftRateLimit['region'] }}" readonly>
                                    </div>
                                    <!-- Add more draft rate limits fields as needed -->
                                @endforeach
                            @else
                                <p>No draft data for rate limits.</p>
                            @endif

                            <!-- Display draft policy enforcement details -->
                            <h3>Policy Enforcement Draft</h3>
                            @if ($draftPolicyEnforcement)
                            <ul>
                                <li>Prevent Submission: {{ $draftPolicyEnforcement->prevent_submission ? 'Yes' : 'No' }}</li>
                                <li>Display Warning: {{ $draftPolicyEnforcement->display_warning ? 'Yes' : 'No' }}</li>
                            </ul>
                                <!-- Add more draft policy enforcement fields as needed -->
                            @else
                                <p>No draft data for policy enforcement.</p>
                            @endif

                            <!-- Save and Cancel Buttons -->
                    <div class="flex items-center justify-end mt-4">
                        <form method="post" action="{{ route('policy.summary.saveOrCancel', ['policy' => $policy->id]) }}">
                            @csrf
                            <button type="submit" name="cancel" class="bg-red-500 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                            <button type="submit" name="save" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </x-app-layout> --}}