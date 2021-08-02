# Lottery API
This app acts as api for the [lotterycamp](https://github.com/limvus/lotterycamp.git) project.

**Technology Used**
- Laravel (Main API)
- Coinbase (Crypto Transaction API)
- Redis (Queue Driver)
- Laravel Echo Server (Realtime Web Socket Server)
- Mysql (Main Database)

# System Requirements
- docker

## Installation
- This app is part of [lotterycamp](https://github.com/limvus/lotterycamp.git) so make sure this repo is 
cloned while cloning lotterycamp then follow the following steps:
```
# create .env file from .env.example. 
cp .env.example .env

# update key variables like
- AppName
- Mail credentials (use mailtrap for dev/ use sendblue for prod)
- Coinbase api info (go to commerce.coinbase.com/settings and get api key and web hook secret)
- put https://api.lotterycamp.com/api/coinbase/webhook in webhook subscriptions
- set broadcast and queue driver to redis

# add vhost in /etc/hosts
127.0.0.1 api.lotterycamp.com # prod
127.0.0.1 api.lotterycamp.local # local dev

# in docker-compose.yml update environment variables in nginx server container
environments:
  - VIRTUAL_HOST=api.lotterycamp.com
  - LETSENCRYPT_HOST=api.lotterycamp.com

# build all the containers and runs it
docker-compose up -d

# install dependencies
docker-compose exec app composer install

# generate unique key
docker-compose exec app php artisan key:generate

# migrate all the tables
docker-compose exec app php artisan migrate

# seed default data
docker-compose exec app php artisan db:seed
```
- Api will be available at:  
https://api.lotterycamp.com

# Key Info about App
- to change branding, search and replace lotterycamp in all variation
- replace logo, favicon (public/images|public/index.js|views/vendor/*/header.blade.php)
- I have disabled wallet transaction emails
- I have set winners to be from seed data only - no new user can be winner

# API Docs
Please visit [API Documentation](https://documenter.getpostman.com/view/3230491/TVsuBSRp)

## Contribution
If you want to contribute, just fork the repository and play around, create 
issues and submit the pull request. Help is always welcomed.

## Security
If you discover any security related issues, please email hello@sudiplimbu.com 
instead of using the issue tracker.

## License
The scripts and documentation in this project are released under the MIT License

## Author
Sudip Limbu
