# SDE Code Exercise

## Requirements

- PHP 8.1+
- [Composer](https://getcomposer.org/)

## Installation

Clone the repository

    git clone https://github.com/EdgarUrias/SDE-Code-Exercise

Go to the directory where you clone the repository

    cd /my/path/SDE-Code-Exercise

Run composer install to install all the dependencies

    composer install

add .env to root runing

    cp .env.example .env

generate app key

    php artisan key:generate

## Usage

The project can be use in two modes CLI or WEB

### CLI

to use the CLI just run the next command in the console in the root of the project

    php artisan shipments:assign /path/to/addresses.txt, /path/to/drivers.txt

the path must be complete for example:

- C:/test/drivers.txt

###  WEB

to use the web example just run the next command in the console:

    php artisan serve

and go to the url

    http://127.0.0.1:8000

there just fallow the instruction on the browser

## Tests

to run the test just run the next command

    php artisan test
