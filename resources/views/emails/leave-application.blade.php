@component('mail::message')
# Leave Application

Dear {{ $approval->name }},

{{$currentUser->name}} have applied for the Leave.
Please visit your dashboard to take action.


Thank you for using our leave application system.

Regards,
{{ config('app.name') }}
@endcomponent
