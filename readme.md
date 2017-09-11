# Gambit – Local environment set-up

### Prep dev env

    Create directory ~/Workspace/vm/profile
    Create directory ~/Workspace/vm/box/gambit2
    Use http://puphpet.com to generate vagrant config from puphpet/config.yaml file.
    Download zip file to ~/Workspace/vm/profile and unzip and rename folder to gambit2.

    In console navigate to ~/Workspace/vm/profile/gambit2
    Run: vagrant up

    This will stand-up the box/environment.

### Pull down code

    $ vagrant ssh
    $ cd /var/www
    $ rm -Rf local.gambit
    $ git clone git@bitbucket.org:oddz/gambit3.git local.gambit

    - Set up IDE env
    -- Create project from existing files
    -- Connect to gambit database through ssh tunnel

    Add .env file (this can't be placed in version control for security reasons)

## Install composer and bower packages

    $ composer install
    $ bower install (this will be replaced with mix... (webpack) hopefully)

    Install local project npm packages

    $ npm install

    Create asset build / distro

    $ grunt

## Create database tables and seed database

    $ php artisan doctrine:migrations:refresh
    ** verify tables were created

    $ php artisan gambit:core:seed
    ** verify data inside users, customers, and sports_games tables

## vhost set-up

    On host machine add the following lines to the /etc/hosts file.

    192.168.56.104  local.gambit-a
    192.168.56.104  local.gambit-b
    
# Gambit Architecture

## Predictable

A predictable is an entity which a prediction can be made on. The system currently
supports one single type of predictable: event. The concept of making a prediction
on an event is the foundation of the entire platform. The architecture is a plugin
based based. Therefore, new plugins (predictable) can be added as needed.

## Prediction Types

A prediction type is a type of prediction. Different types of predictions will require
differing data/options for customers to make their prediction. For example, a money line
prediction on a sporting event like a football game only requires one to pick the winning
team in the event. However, a point spread prediction on a sporting event also requires
a spread. Like the predictable system this is also plugin based. New types of predictions
can be added as needed such as a prediction to handle over/under bets.

## Sites and Stores

The system has been built to scale and support multiple sites. It is a two tier architecture. The top
level tier is referred to as a "site". A single site will share the same customer pool across its store.
Each site has a completely separate customer pool. Customer pool as the term implies are all the customers
that have registered in the store. Stores are meant to serve the purpose of differing themes or languages
for a single site.

## Products

The system has three types of products having been built as a glorified ecomm solution. The first
type is an advertised line. An advertised line is indirectly created when customers submit a bet slip with a prediction that they
have made. Once submitted the advertised line will become available for other customers to
accept. The second type of product is a accepted line. An accepted line is a product where the customer
accepts the inverse scenario of the advertised line. The last type of product is a credit. To purchase and 
accept lines credits will be used.

## Quotes and Sales

Keeping with the philosophy of an ecomm set-up orders are divided between two parts: quotes and sales. A quote
is sale that has not been fulfilled yet and can be thought of as the "cart". Cart in the system is referred 
to as a slip but cart and slip are essentially synonymous. A slip that has been been submitted is turned
into a sale. A sale will contain much of the same data that the quote had for record keeping and fulfillment
purposes.

## Accounting

A ledger based system has been implemented to track all sales and transfers of funds between customers
and each individual site. The ledger currently supports two types of assets: usd and credits. Two
cashbooks are maintained for each site and customer. On cashbook is for external sales that involve
exchanging real money for credits and vice versa. The other is an internal cashbook that tracks credit
based exchanges only.



# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
