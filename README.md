# OneLineAPC

Dead simple wrapper class for [APC](http://php.net/manual/en/intro.apc.php) and [APCu](http://php.net/manual/en/intro.apcu.php) which capable of setting and getting cached data from a callback in one single line.

## Installation

Install with [Composer](https://getcomposer.org):

```
composer require benjaminabel/one-line-apc
```

## Usage

```php
require 'vendor/autoload.php';
$cache = new OneLineAPC();
```

By default, this class uses [APC](http://php.net/manual/en/intro.apc.php).
To use [APCu](http://php.net/manual/en/intro.apcu.php) just pass it while instantiating the class:

```php
$cache = new OneLineAPC('apcu');
```

Default TTL is 79200 (22 hours). To change it, call `setTtl` method:

```php
$cache->setTtl(3600);
```

OR, specify it individually as a last argument to `setCache` or `cached` methods:

```php
$cache->setCache($dataToCache, 'key', 3600);
```

## Cached

The main and the most important method (the reason I created this class) is called `cached`:

```php
$cache->cached('key', 'functionName');
```

`functionName` is the name of some function in your code which returns the data that needs to be cached.
In case your function is within some class, pass it as an array of Object and a function name:

```php
$cache->cached('cacheKey', array($obj, 'functionName'));
```

You can find out more about callbacks [here](http://php.net/manual/en/language.types.callable.php).

## Notes

If `apc` or `apcu` is not loaded, this class will generate "Notice", instead of "Fatal Error".