@component('mail::message')
<style>
    .transaction-detail {
        border-collapse: collapse;
        width: 100%;
    }

    .transaction-detail, .transaction-detail th, .transaction-detail td {
        border: 1px solid black;
    }
</style>
<h1>
    Hi {{ $fullname }},
</h1>
<p>
We have received your request to withdraw an amount of {{ $amount }} BTC. Your request has been put to processing queue.
<br>
</p>
<table class="transaction-detail">
    <tr>
        <th>Amount</th>
        <th>Status</th>
        <th>Created At</th>
    </tr>
    <tr>
        <td>{{ $amount }} BTC</td>
        <td>{{ $status }}</td>
        <td>{{ $created_at }}</td>
    </tr>
</table>
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
