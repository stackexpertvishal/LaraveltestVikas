# Laravel Assignment

## Scope
### This application has APIs for login, register, add money to wallet and Buy Cookies 
# setp 1 = Create User 
# step 2 = Login User
# step 3 - copy the token
# step 4 - add token in headers and hit addMoneyToWallet api 
# step 5 - for purchasing the cookie you must hit api buyCookie

## Requirements
### PHP version 8.0 or above and composer

## Please run following commands for setup after cloning

```
composer install
```
```
php artisan jwt:secret
```

## Setup .env file for Database and create new database

```
php artisan migrate
```