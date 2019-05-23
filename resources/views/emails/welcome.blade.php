@component('mail::message')

<h1>
    Hello,
</h1>

Welcome to LokSewa.

Please click on the button below or copy it into the address bar of your browser to confirm your email address:
<br>
@component('mail::button', ['url' => url('register/verify/'. $user->email_token )])
    Verify Now
@endcomponent

You can start posting your ad on LokSewa

Thanks,<br>
{{ config('app.name') }}
@endcomponent
