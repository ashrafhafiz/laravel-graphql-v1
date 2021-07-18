<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400"></a></p>
<p  align="center">
<a  href="https://travis-ci.org/laravel/framework"><img  src="https://travis-ci.org/laravel/framework.svg"  alt="Build Status"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://img.shields.io/packagist/dt/laravel/framework"  alt="Total Downloads"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://img.shields.io/packagist/v/laravel/framework"  alt="Latest Stable Version"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://img.shields.io/packagist/l/laravel/framework"  alt="License"></a>
</p>

  

# How to Build a GraphQL API Using Laravel

  

Ripped from original articel [How to Build a GraphQL API Using Laravel
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

This will create a new project in a new directory called `laravel-graphql-v1`.

Moving on, if you go to localhost you should see something like this:

<img  src="https://www.freecodecamp.org/news/content/images/2021/05/2.png"  alt="Build Status">

  

But before we move on, there are some packages that we need to install first:
 - IDE helper for laravel, always useful to have.

    composer require --dev barryvdh/laravel-ide-helper

 - GraphQL library which we are going to use:

    composer require rebing/graphql-laravel

Next we have to publish the GraphQL library like this:

    php artisan vendor:publish --provider="Rebing\\GraphQL\\GraphQLServiceProvider"

This should create a GraphQL config file that we will use in `config/graphql.php`.

## How to Create the Migrations and Models

This isn't a Laravel tutorial, so we'll quickly create the models with the appropriate migrations.

Let's start with category model:

```bash
# Create model with migrations
php artisan make:model -m Post

```
This will create the Post model with it's migration file.

Our category will consist of four fields:

- id
- user_id
- title
- comment
- created_at
- updated_at

Our post migrations file should look like this:

```bash
<?php

use  Illuminate\Database\Migrations\Migration;
use  Illuminate\Database\Schema\Blueprint;
use  Illuminate\Support\Facades\Schema;
  
class  CreatePostsTable  extends  Migration
{
	/**
	* Run the migrations.
	*
	* @return  void
	*/
	public  function  up()
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('title');
			$table->text('comment');
			$table->timestamps();
		});
	}
  
	/**
	* Reverse the migrations.
	*
	* @return  void
	*/
	public  function  down()
	{
		Schema::dropIfExists('posts');
	}
}
```

Next let's configure the post model class.

We will do two things here:

-   Make the fields `user_id`, `title`,`comment`  editable, so we will add it to our  `$fillable`  array.
-   Define the relationship between post model and user model.
```bash
<?php
  
namespace  App\Models;
  
use  Illuminate\Database\Eloquent\Factories\HasFactory;
use  Illuminate\Database\Eloquent\Model;
  
class  Post  extends  Model
{
	use  HasFactory;
	  
	protected $fillable = ['user_id', 'title', 'comment'];
	  
	public  function  user()
	{
		return  $this->belongsTo(User::class);
	}
}
```
With both the migrations and models ready, we can apply the changes to the database.

Run this command:

```bash
# Apply migrations
sail artisan migrate

```

Our database should be updated! Next we should put some data into our tables.

## How to Seed the Database

We need data to work with, but as developers we are too lazy to manually do it.

This is where factories come.

First, we'll create the factory classes for both the quest and category model.

Run the following commands:

```bash
# Create a factory class for quest model
php artisan make:factory PostFactory --model=Post
```

This will create for us a new class:

-   `PostFactory`  – a class that helps us generate posts.

Let's start with the  `PostFactory`. In our  `definitions`  function we will tell Laravel how each field should be generated. For the field  `user_id`, we will pick a random user.
```bash
<?php
  
namespace  Database\Factories;
  
use  App\Models\Post;
use  App\Models\User;
use  Illuminate\Database\Eloquent\Factories\Factory;
  
class  PostFactory  extends  Factory
{
	/**
	* The name of the factory's corresponding model.
	*
	* @var  string
	*/
	protected $model = Post::class;
	  
	/**
	* Define the model's default state.
	*
	* @return  array
	*/
	public  function  definition()
	{
		$userIDs = User::all()->pluck('id')->toArray();
		return [
			// 'user_id' => rand(1, 10),
			// 'title' => $this->faker->title(),
			// 'title' => $this->faker->name(),
			'user_id' => $this->faker->randomElement($userIDs),
			'title' => $this->faker->realText(25),
			'comment' => $this->faker->realText(180)
		];
	}
}
```
`UserFactory` is much simpler, as we simply have to execute it, since it is automatically generated while creating the Laravel project.

Now instead of creating seeders, we will simply run the factory create method inside `DatabaseSeeder.php`:
```bash
<?php
  
namespace  Database\Seeders;
  
use  Illuminate\Database\Seeder;
  
class  DatabaseSeeder  extends  Seeder
{
	/**
	* Seed the application's database.
	*
	* @return  void
	*/
	public  function  run()
	{
		\App\Models\User::factory(10)->create();
		\App\Models\Post::factory(10)->create();
	}
}
```



