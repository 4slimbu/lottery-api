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
@if($transaction_type === 'win')
    Congratulation, you have won {{$amount_in_btc}} BTC.
@endif

@if($transaction_type === 'top-up')
    You have deposited {{$amount_in_btc}} BTC which converts to {{$amount_in_coin}} coins.
@endif

@if($transaction_type === 'order')
    You have joined a game and {{$amount_in_coin}} Coin has been deducted from your wallet.
@endif

@if($transaction_type === 'withdraw')
        You have withdrawn {{$amount_in_btc}} BTC from your wallet.
@endif
<br>
Here's your wallet transaction detail.
<br>
</p>
<table class="transaction-detail">
    <tr>
        <th>Transaction Code</th>
        <th>Type</th>
        <th>Amount</th>
        @if( $transaction_type === 'win')
            <th>Service Charge</th>
            <th>Total</th>
        @endif
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
        @if( $transaction_type === 'win')
            <td>{{ $service_charge_in_btc }} BTC</td>
            <td>{{ $amount_in_btc * 1 + $service_charge_in_btc * 1 }} BTC</td>
        @endif
        <td>{{ $created_at }}</td>
    </tr>
</table>
<br>
<br>
<p>
    And, here's your new wallet status
</p>
<table class="transaction-detail">
    <tr>
        <th>Won</th>
        <th>Pending Withdraw</th>
        <th>Deposit</th>
    </tr>
    <tr>
        <td>{{ $won }} BTC</td>
        <td>{{ $pending_withdraw }} BTC</td>
        <td>{{ $deposit }} {{ $deposit > 1 ? ' Coins' : ' Coin' }}</td>
    </tr>
</table>
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
