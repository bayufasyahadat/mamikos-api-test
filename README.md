# Getting started

# About This Repository

This project using Laravel 8 with Laravel Sanctum Auth.

# What I Use

- PHP 8.0.13

- Laravel 8.76.2

- Laravel Sanctum for Authentication

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x)

Clone the repository

    git clone git@github.com:bayufasyahadat/mamikos-api-test.git

Switch to the repo folder

    cd mamikos-api-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the Seeder for Role default values

    php artisan db:seed

Run to make public folder accessible from the web, you should create a symbolic link with

    php artisan storage:link

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan serve

# Scheduling Task

This project also implement scheduled task for recharge credit for every first day of the month.

To run manually the scheduling:

1. Check the task

```
    php artisan monthly:autocredits
```

2. Run the task

```
    php artisan list