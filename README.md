Laravel Eloquent Rating
=======================

![CI](https://github.com/renoki-co/rating/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/rating/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/rating/branch/master)
[![StyleCI](https://github.styleci.io/repos/142049701/shield?branch=master)](https://github.styleci.io/repos/141194551)
[![Latest Stable Version](https://poser.pugx.org/rennokki/rating/v/stable)](https://packagist.org/packages/rennokki/rating)
[![Total Downloads](https://poser.pugx.org/rennokki/rating/downloads)](https://packagist.org/packages/rennokki/rating)
[![Monthly Downloads](https://poser.pugx.org/rennokki/rating/d/monthly)](https://packagist.org/packages/rennokki/rating)
[![License](https://poser.pugx.org/rennokki/rating/license)](https://packagist.org/packages/rennokki/rating)

Laravel Eloquent Rating allows you to assign ratings to any model, just like any other review based on stars.

## 🤝 Supporting

Renoki Co. on GitHub aims on bringing a lot of open source projects and helpful projects to the world. Developing and maintaining projects everyday is a harsh work and tho, we love it.

If you are using your application in your day-to-day job, on presentation demos, hobby projects or even school projects, spread some kind words about our work or sponsor our work. Kind words will touch our chakras and vibe, while the sponsorships will keep the open source projects alive.

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R42U8CL)

## 🚀 Installation

Install the package:

```bash
$ composer require rennokki/rating
```

Publish the config:

```bash
$ php artisan vendor:publish --provider="Rennokki\Rating\RatingServiceProvider" --tag="config"
```

Publish the migrations:

```bash
$ php artisan vendor:publish --provider="Rennokki\Rating\RatingServiceProvider" --tag="migrations"
```

## Preparing the model

To allow a model to rate other models, it should use the `CanRate` trait and implement the  `Rater` contract.

```php
use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rater;

class User extends Model implements Rater
{
    use CanRate;
    ...
}
```

The other models that can be rated should use `CanBeRated` trait and `Rateable` contract.

```php
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Contracts\Rateable;

class User extends Model implements Rateable
{
    use CanBeRated;
    ...
}
```

If your model can both rate & be rated by other models, you should use `Rate` trait and `Rating` contract.

```php
use Rennokki\Rating\Traits\Rate;
use Rennokki\Rating\Contracts\Rating;

class User extends Model implements Rating
{
    use Rate;

    //
}
```

## 🙌 Usage

To rate other models, simply call `rate()` method:

```php
$page = Page::find(1);

$user->rate($page, 10);
$user->hasRated($page); // true
$page->averageRating(User::class); // 10.0, as float
```

As a second argument to the `rate()` method, you can pass the rating score. It can either be string, integer or float.

To update a rating, you can call `updateRatingFor()` method:

```php
$user->updateRatingFor($page, 9);
$page->averageRating(User::class); // 9.00, as float
```

As you have seen, you can call `averageRating()` within models that can be rated. The return value is the average arithmetic value of all ratings as `float`.

If we leave the argument empty, we will get `0.00` because no other `Page` model has rated the page so far. But since users have rated the page, we will calculate the average only from the `User` models, since only they have voted the page, strictly by passing the class name as the argument.

```php
$page = Page::find(1);

$user1->rate($page, 10);
$user2->rate($page, 6);

$page->averageRating(); // 0.00
$page->averageRating(User::class); // 8.00, as float
```

While in our example, the `User` class can both rate and be rated, we can leave the argument empty if we reference to its class:

```php
$user = User::find(1);

$user1->rate($user, 10);
$user2->rate($user, 6);

$user->averageRating(); // 8.00, as float
$user->averageRating(User::class); // 8.00, it is equivalent
```

The relationships are based on this too:

```php
$page->raters()->get(); // Pages that have rated this page
$page->raters(User::class)->get(); // Users that have rated this page

$user->ratings()->get(); // Users that this user has rated
$user->ratings(Page::class)->get(); // Pages that this user has rated
```

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)
