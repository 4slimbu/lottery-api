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

Once you verify, your limitations will be removed. Have fun!!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
