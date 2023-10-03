<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <a href="{{ url('/expense-types') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">Add Expense</a>
    <a href="{{ url('/add-policy') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">Policy</a>
    <a href="{{ url('/apply-expense') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">Apply</a>
    <a href="{{ url('/add-department') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">Department</a>
    <a href="{{ url('/add-section') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">Section</a>
    <a href="{{ url('/create-user') }}" class="font-semibold text-gray-900 hover:text-White-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-white-800">User</a>




    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in as Admin!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
