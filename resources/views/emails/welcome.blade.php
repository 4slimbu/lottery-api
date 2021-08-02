@component('mail::message')

<h1>
    Hello,
</h1>

Welcome to {{ config('app.name') }}.

Please use the following code to verify your email address:
<br>

<strong>{{ $user->email_token }}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
