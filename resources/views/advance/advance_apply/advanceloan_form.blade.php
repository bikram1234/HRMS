
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for Advance Loan') }}
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

                    <!-- DSA Advance Form -->
                    <div id="dsa_advance_form" class="advance-fields" style="display: none;">
                        <form method="POST" action="{{ route('Add-Advance') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="advance_type" value="dsa_advance">
                            <!-- DSA Advance fields here -->
                            <div class="mb-3">
                                <label for="mode_of_travel" class="form-label">{{ __('Mode of Travel') }}</label>
                                <input id="mode_of_travel" class="form-control" type="text" name="mode_of_travel" required />
                            </div>
                            <div class="mb-3">
                                <label for="from_location" class="form-label">{{ __('From Location') }}</label>
                                <input id="from_location" class="form-control" type="text" name="from_location" :value="old('from_location')" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="to_location" class="form-label">{{ __('To Location') }}</label>
                                <input id="to_location" class="form-control" type="text" name="to_location" :value="old('to_location')" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="from_date" class="form-label">{{ __('From Date') }}</label>
                                <input id="from_date" class="form-control" type="date" name="from_date" :value="old('from_date')" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="to_date" class="form-label">{{ __('To Date') }}</label>
                                <input id="to_date" class="form-control" type="date" name="to_date" :value="old('to_date')" required />
                            </div> 
                            <div class="mb-3">
                                <label for="amount" class="form-label">{{ __('Amount') }}</label>
                                <input id="amount" class="form-control" type="number" name="amount" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="purpose" class="form-label">{{ __('Purpose') }}</label>
                                <input id="purpose" class="form-control" type="text" name="purpose" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="upload_file" class="form-label">{{ __('Upload File (Optional)') }}</label>
                                <input id="upload_file" class="form-control" type="file" name="upload_file" accept=".pdf" />
                            </div>                                                  
                             <button type="submit">Submit DSA Advance</button>
                        </form>
                    </div>

                    <!-- Salary Advance Form -->
                    <div id="salary_advance_form" class="advance-fields" style="display: none;">
                        <form method="POST" action="{{ route('Add-Advance') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="advance_type" value="salary_advance">
                            <!-- Salary Advance fields here -->
                            <div class="mb-3">
                                <label for="emi_count" class="form-label">{{ __('EMI Count') }}</label>
                                <input id="emi_count" class="form-control" type="number" min="1" name="emi_count" required />
                            </div>
                            <div class="mb-3">
                                <label for="deduction_period" class="form-label">{{ __('Deduction Period') }}</label>
                                <input id="deduction_period" class="form-control" type="date" name="deduction_period" :value="old('Deduction period')" required />
                            </div> 
                            <div class="mb-3">
                                <label for="amount" class="form-label">{{ __('Amount') }}</label>
                                <input id="amount" class="form-control" type="number" name="amount" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="purpose" class="form-label">{{ __('Purpose') }}</label>
                                <input id="purpose" class="form-control" type="text" name="purpose" required />
                            </div>
    
                            <div class="mb-3">
                                <label for="upload_file" class="form-label">{{ __('Upload File (Optional)') }}</label>
                                <input id="upload_file" class="form-control" type="file" name="upload_file" accept=".pdf" />
                            </div>                                                           
                             <button type="submit">Submit Salary Advance</button>
                        </form>
                    </div>

                    <div class="mb-3">
                        <label for="advance_type" class="form-label">{{ __('Advance Type') }}</label>
                        <select id="advance_type" class="form-select" name="advance_type" required>
                            <option value="none">Select Advance Type</option>
                            @foreach ($advance_type as $advancetype)
                            <option value="{{ $advancetype->name }}">{{ $advancetype->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" id="submit_button" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const advanceTypeSelect = document.getElementById("advance_type");
            const dsaAdvanceForm = document.getElementById("dsa_advance_form");
            const salaryAdvanceForm = document.getElementById("salary_advance_form");
            const submitButton = document.getElementById("submit_button");

            advanceTypeSelect.addEventListener("change", function() {
                const selectedType = this.value;
                dsaAdvanceForm.style.display = selectedType === "DSA Advance" ? "block" : "none";
                salaryAdvanceForm.style.display = selectedType === "Salary Advance" ? "block" : "none";
            });

            submitButton.addEventListener("click", function() {
                const selectedType = advanceTypeSelect.value;
                if (selectedType === "DSA Advance") {
                    dsaAdvanceForm.querySelector("form").submit();
                } else if (selectedType === "Salary Advance") {
                    salaryAdvanceForm.querySelector("form").submit();
                }
            });
        });
    </script>
</x-app-layout>
