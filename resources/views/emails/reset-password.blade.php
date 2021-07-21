@component('mail::message')

<h1>
    Hi {{ $name }},
</h1>

We received an attempt to reset your password. If this was an intended request, please use the code below
on the verification page to continue the reset process.
<br>
{{ $token }}
<br>

If it wasn't you who requested to reset your password, then ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
