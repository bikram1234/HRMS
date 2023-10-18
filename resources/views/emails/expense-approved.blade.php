@component('mail::message')
# Leave Application

Dear {{ $user->name }},

The Expense you have applied for has been approved.

Thank you for using our Expense application system.

Regards,
{{ config('app.name') }}
@endcomponent
