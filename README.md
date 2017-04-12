## Forest Pay

[![Build Status](https://travis-ci.org/HughbertD/forest-pay.svg?branch=master)](https://travis-ci.org/HughbertD/forest-pay.svg?branch=master)

Technical test for a prospective employer.

### Installation

##### Environment
Run locally using an older version of  Laravel's Homestead to satisfy technical requirements:
- PHP 5.6 
- Laravel 4.2
- MySQL 5.7

To use this setup you can visit: 
https://github.com/gjrdiesel/homestead56

##### Repository

Clone the repository into your local environment:
`git clone git@github.com:HughbertD/forest-pay.git`

Database configuration for local is in:
`app/config/local/database.php`

On the command line use:
`php artisan migrate`
`php artisan db:seed`

To create the necessary tables, as well as some seed data

Tests can be run using `phpunit` from the root dir

### License

This repository is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
