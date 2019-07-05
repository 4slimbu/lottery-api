# Lottery API
This application provides api for the lottery app.

### API CODES

### Events
- LotterySlotCreatedEvent
- WalletTransactionEvent
- LotterySlotResultGeneratedEvent
- LotterySlotClosedEvent
- ParticipantAddedEvent

### Real Time config
This app uses following technologies to achieve real time 
functionality:
- laravel-echo-server (on api as broadcast driver)
- predis/predis (on api as queue/database driver)
- socket.io-client (on app as broadcaster technology)
- laravel-echo (on app as broadcast listener)

Any event should implements ShouldBroadcast to successfully
broadcast events

To make broadcasting work make sure you have run these commands:
laravel-echo-server start
php artisan queue:listen --tries=1

For windows: 
Setup task scheduler like cron and run "php artisan schedule:run" using it

Reference:
https://laravel.com/docs/5.8/broadcasting
https://blog.usejournal.com/laravel-echo-server-how-to-24d5778ece8b

### Webhook
For local development, I used ngrok to tunnel local web server
to online.
- download ngrok.exe for windows then execute:
    ngrok http 8000 (for laravel api when server is created using: php artisan serve)
    
Docs:
https://dashboard.ngrok.com/get-started

Following url can be used to view response of webhook:
http://localhost:4040

### Payment integration
- When user click on deposit
	- show form to let them fill how much they want to deposit
	- Create an pending order
	- Create charge with the deposit amount and order id as meta data
	- Show user the charge on popup: https://commerce.coinbase.com/charges/charge-code
	- When user pays and the charge is confirmed, redirect user to home page
	- In the backend, it will receive charge:completed event which is processed and order is updated with completed status. Also, amount will be added to wallet, then amount added event will be broadcasted to that particular user.
	- In the frontend, the particular user will see his/her updated wallet.

Payment integration is handled by coinbase-commerce.
For laravel, following package is used to ingegrate coinbase-commerce:
https://github.com/shakurov/laravel-coinbase

Docs for coinbase-commerce:
https://commerce.coinbase.com/docs/api