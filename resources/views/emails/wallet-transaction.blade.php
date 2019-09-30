@component('mail::message')

<h1>
    Hi {{ $fullname }},
</h1>

@if($transaction_type === 'win')
    Congratulation, you have won {{$amount_in_btc}} BTC.
@endif;

@if($transaction_type === 'top-up')
    You have deposited {{$amount_in_btc}} BTC which converts to {{$amount_in_coin}} coins.
@endif;

@if($transaction_type === 'order')
    You have joined a game and {{$amount_in_coin}} Coin has been deducted from your wallet.
@endif;

@if($transaction_type === 'withdraw')
@endif;

<br>
Here's your wallet transaction detail.
<br>
<table>
    <tr>
        <th>Transaction Code</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Created At</th>
    </tr>
    <tr>
        <td>{{ $transaction_code }}</td>
        <td>{{ $transaction_type }}</td>
        <td>
            {{ $transaction_type === 'win' ? $amount_in_btc . " BTC" : "" }}
            {{ $transaction_type === 'top-up' ? $amount_in_coin . " Coins" : "" }}
            {{ $transaction_type === 'order' ? $amount_in_coin . " Coins" : "" }}
            {{ $transaction_type === 'withdraw' ? $amount_in_btc . " BTC" : "" }}
        </td>
        <td>{{ $created_at }}</td>
    </tr>
</table>
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
