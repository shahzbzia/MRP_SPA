@component('mail::message')
# Invitation Email

You have recieved an invitation to join Meeting Room Planner, Click on 'Register' to complete your account registeration.

@component('mail::button', ['url' => config('app.url'). '/' . app()->getLocale() . '/register?invitation_token=' . $token])
Register
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
