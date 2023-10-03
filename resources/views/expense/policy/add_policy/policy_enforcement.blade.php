<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Policy Enforcement') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="container">
                <h2 class="text-2xl font-bold mb-4">Policy Enforcement for {{ $policy->name }}</h2>

                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('policy-enforcement.store', ['policy' => $policy->id]) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="enforcement_options">Enforcement Options</label>
                        <div class="flex">
                            <div class="mr-4">
                                <input class="form-checkbox" type="checkbox" id="prevent_submission" name="enforcement_options[]" value="prevent_submission">
                                <label class="ml-2" for="prevent_submission">Prevent report submission</label>
                            </div>
                            <div class="mr-4">
                                <input class="form-checkbox" type="checkbox" id="display_warning" name="enforcement_options[]" value="display_warning">
                                <label class="ml-2" for="display_warning">Display warning to user</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center mt-4">
                        <button type="submit" style="background-color: #3490dc; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                            {{ __('submit') }}
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
