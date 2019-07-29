@component('mail::message')

<h1>
    Hello {{ $userType === 'admin' ? 'Admin' : $name }},
</h1>
{{ $userType === 'admin' ? 'New Inquiry received' : 'Your inquiry has been received and will be addressed as soon as possible.' }}
<br />

<strong>name: {{ $name }}</strong> <br />
<strong>email: {{ $email }}</strong> <br />
<strong>subject: {{ $subject }}</strong> <br />
<strong>message: {{ $message }}</strong> <br />
<strong>message: {{ $message }}</strong> <br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
