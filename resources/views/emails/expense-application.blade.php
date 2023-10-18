@component('mail::message')
# Leave Application

Dear {{ $approval->name }},

{{$currentUser->name}} have applied for the a request of expense.
Please visit your dashboard to take action.


Thank you for using our Expense application system.

Regards,
{{ config('app.name') }}
@endcomponent
