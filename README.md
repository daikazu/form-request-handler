# Form Request Handler

[![Build Status](https://travis-ci.org/daikazu/form-request-handler.svg?branch=master)](https://travis-ci.org/daikazu/form-request-handler)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/daikazu/form-request-handler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/daikazu/form-request-handler/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/daikazu/form-request-handler/badge.svg?branch=master)](https://coveralls.io/github/daikazu/form-request-handler?branch=master)

[![Packagist](https://img.shields.io/packagist/v/daikazu/form-request-handler.svg)](https://packagist.org/packages/daikazu/form-request-handler)
[![Packagist](https://poser.pugx.org/daikazu/form-request-handler/d/total.svg)](https://packagist.org/packages/daikazu/form-request-handler)
[![Packagist](https://img.shields.io/packagist/l/daikazu/form-request-handler.svg)](https://packagist.org/packages/daikazu/form-request-handler)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require daikazu/form-request-handler
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Daikazu\FormRequestHandler\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Daikazu\FormRequestHandler\Facades\FormRequestHandler::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Daikazu\FormRequestHandler\ServiceProvider" --tag="config"
```

## Usage

CHANGE ME

## Security

If you discover any security related issues, please email 
instead of using the issue tracker.

## Credits

- [](https://github.com/daikazu/form-request-handler)
- [All contributors](https://github.com/daikazu/form-request-handler/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
