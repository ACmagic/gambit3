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
