<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# How to Build a GraphQL API Using Laravel

ripped from original articel [How to Build a GraphQL API Using Laravel
](https://www.freecodecamp.org/news/build-a-graphql-api-using-laravel/) by: [Tamerlan Gudabayev](https://www.freecodecamp.org/news/author/tamerlan/)
## Prerequisites
Before we begin, make sure to have these installed on your system:
- PHP 7+
- Composer 2.0
- Docker 20.10.6 (Any other version should be fine)
- Docker-Compose 1.29.1 (Any other version should be fine)

I also assume that you have:
- Basic knowledge of Laravel (Eloquent, Migrations, MVC, Routes, and so on)
- Knowledge of PHP (Syntax, OOP, and so on)
- Basic knowledge of GraphQL (in theory)

## How to Initialize the Project
Create a Laravel project using this command:
composer create-project laravel/laravel laravel-graphql-v1
This will create a new project in a new directory called laravel-graphql-v1.

Moving on, if you go to localhost you should see something like this:

<img src="https://www.freecodecamp.org/news/content/images/2021/05/2.png" alt="Build Status">

But before we move on, there are some packages that we need to install first:

- IDE helper for laravel, always useful to have.

<code>composer require --dev barryvdh/laravel-ide-helper</code>

- GraphQL library which we are going to use:

<code>composer require rebing/graphql-laravel</code>

Next we have to publish the GraphQL library like this:
php artisan vendor:publish --provider="Rebing\\GraphQL\\GraphQLServiceProvider"

This should create a GraphQL config file that we will use in config/graphql.php.

