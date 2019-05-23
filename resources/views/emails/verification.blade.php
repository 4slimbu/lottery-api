@component('mail::message')

<h1>
    Hello,
</h1>

We received a request to re-send you the email verification code.

Please copy the following code into the verify page of your app to confirm your email address:
<br>
<p>
    <strong>{{ $token }}</strong>
</p>
<br>
You can start posting your ad on LokSewa

Thanks,<br>
{{ config('app.name') }}
@endcomponent
