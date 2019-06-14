# Lottery API
This application provides api for the lottery app.

# API CODES

# Events
- LotterySlotCreatedEvent
- WalletTransactionEvent
- LotterySlotResultGeneratedEvent
- LotterySlotClosedEvent
- ParticipantAddedEvent

# Real Time config
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

Reference:
https://laravel.com/docs/5.8/broadcasting
https://blog.usejournal.com/laravel-echo-server-how-to-24d5778ece8b
