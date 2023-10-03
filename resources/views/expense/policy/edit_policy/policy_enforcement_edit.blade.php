<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Policy Enforcement') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <h1>Edit Policy Enforcement</h1>
        <form method="POST" action="{{ route('update-policy-enforcement', ['policy' => $policy->id]) }}">
            @csrf

            <!-- Display the fields that can be edited -->
            <div class="form-group">
                <label for="enforcement_options">Enforcement Options:</label>
                <input type="checkbox" id="prevent_submission" name="enforcement_options[]" value="prevent_submission" {{ optional($enforcementOptions)->prevent_submission == 1 ? 'checked' : '' }}>               
                
                <label for="prevent_submission">Prevent Submission</label>
                <input type="checkbox" id="display_warning" name="enforcement_options[]" value="display_warning" {{ optional($enforcementOptions)->display_warning == 1 ? 'checked' : '' }}>
                <label for="display_warning">Display Warning</label>
            </div>
            <br><br>

            <!-- Add a "Save" button to submit the form -->
            <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.1rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                {{ __('Save') }}
            </button>

            <!-- Add a "Cancel" button that redirects back to the edit page with the existing data -->
            <button type="button" style="background-color: #dc5b34; color: white; font-weight: bold; padding: 0.1rem 1rem; border-radius: 0.25rem; cursor: pointer;" class="btn btn-secondary" onclick="window.location.href='{{ route('edit-policy-enforcement', ['policy' => $policy->id]) }}'">
                Cancel
            </button>
        </form>
    </div>
</x-app-layout>
