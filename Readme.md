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
# you can update various config like db credentials, smtp credentials etc. here.
# default is fine for test purpose 
cp .env.example .env

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
http://localhost:8000

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