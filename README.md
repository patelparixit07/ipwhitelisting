# IP Whitelisting

Simple Laravel Package to increase the security of the website by permitting access for users having whitelisted IP Addresses.

In this package, you can add IP Addresses into whitelist which you want to allow access to your site. All other users coming from IPs which are not in whitelist will automatically blocked and won't access site. 

## Installation

via composer

```bash
composer require webtoppings/ipwhitelisting
```

## Supports

Laravel 5.5 or higher

## Configure

Run below commands to publish views and migrate tables

```bash
php artisan vendor:publish

php artisan migrate
```

## Usage

### Manage Whitelist

Add below route to your administrator route group to manage whitelist IP Addresses

```php
Route::resource('/ipwhitelisting', '\WebToppings\IPWhitelisting\IPWhitelistingController');
```

### Restrict Access

Use middleware to restrict IP Addresses

```php
'IPBlocking' => \WebToppings\IPWhitelisting\Middlewares\IPBlocking::class,
```

Add ```IPBlocking``` middleware to route group for which you want to restrict access.

Users will be redirect to "403 | Forbidden" page if their IP won't exist on whitelist.

## License
[MIT](https://choosealicense.com/licenses/mit/)
