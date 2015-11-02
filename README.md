# PotatoORM

[![License](http://img.shields.io/:license-mit-blue.svg)](https://github.com/andela-sakande/PotatoORM/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/andela-sakande/potatoORM.svg)](https://travis-ci.org/andela-sakande/potatoORM)
[![Quality Score](https://img.shields.io/scrutinizer/g/andela-sakande/PotatoORM.svg?style=flat-square)](https://scrutinizer-ci.com/g/andela-sakande/PotatoORM)
<!-- [![Scruitinizer Code](https://scrutinizer-ci.com/g/andela-sakande/PotatoORM/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andela-sakande/PotatoORM) -->

This package performs basic CRUD operation using Object Relational Mapping(ORM) :

DIRECTORY STRUCTURE
-------------------

```
src/           core package code
   |DB         database connection class
   |Entities   samples class to test the model class
   |Exceptions custom exception classes
   |Libraries  helper classes
tests/         tests of the core package
```

## Installation

[PHP](https://php.net) 5.3+ and [Composer](https://getcomposer.org) are required.

Via Composer

``` bash
$ composer require sirolad/potato-orm
```
or
``` composer.json
"require": {
        "sirolad/potato-orm": "dev-master"
    }
```

## Usage

Extend `Potato` class like so
``` php
    class Goat extends Potato
    {
    }
```
The following method can be used to access the classes

## getAll
``` php
   $goat = Goat::getAll();
   print_r($goat);
```
This should print out all the ​goats ​in the ​goats ​table of Goat class.

## find
``` php
    $goat = Goat::find(1);
    $goat->password = "ewure";
    echo $goat->save();
```
This should find the ​goat ​with `id=1` in the goats table and change the password to `ewure`.

## save
```php
    $goat = new Goat();
    $goat->name = "billy";
    $goat->age  = 25;
    $goat->job  = "developer";
    $goat->save();
```
This should insert a record for goat `billy` in the goats table.

## Update
```php
    $gaot = Goat::where('name', 'JackBauer');
    $gaot->password = "wetina";
    $gaot->save();
```

## Change log

Please check out [CHANGELOG](CHANGELOG.md) file for information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit test
```

``` composer
$ composer test
```

## Contributing

Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits

Open-source Evangelist is developed and maintained by `Surajudeen Akande`.

## License

Open-source Evangelist is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for details.

## Supported Databases

``` bash
MySQL
PGSQL
```
