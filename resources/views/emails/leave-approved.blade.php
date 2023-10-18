@component('mail::message')
# Leave Application

Dear {{ $user->name }},

The leave you have applied for has been approved.

Thank you for using our leave application system.

Regards,
{{ config('app.name') }}
@endcomponent
