# Ek$iBorsa 
========================================================================================================================================================================================================================================================================================

[![Build Status](https://travis-ci.org/Seldar/eksiborsa.svg?branch=master)](https://travis-ci.org/Seldar/eksiborsa) 
[![codecov.io](http://codecov.io/github/Seldar/eksiborsa/coverage.svg?branch=master)](http://codecov.io/github/Seldar/eksiborsa?branch=master) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eksiborsa/job-board/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Seldar/eksiborsa/?branch=master)

Ek$iborsa is a a browser based stock exchange game developed with laravel

Requirements
------------

  * PHP 5.3 or higher;
  * [Laravel 5.3.*](https://github.com/laravel/laravel)
  * [abraham/twitteroauth](https://github.com/abraham/twitteroauth)
  * [j7mbo/twitter-api-php](https://github.com/J7mbo/twitter-api-php)
  * [PHPUnit 5.4](https://github.com/sebastianbergmann/phpunit) or higher.

Installation
------------


Install using composer:

```bash
$ composer install
```

Run Database Migration and Seeds for sample data:

```bash
php artisan migrate
php artisan db:seed
```

Run below command to generate a unique key for security. 

```bash
php artisan key:generate
```
Usage
-----

After installation point your browser to "public/" directory. UnitTests can be run in tests/ folder.