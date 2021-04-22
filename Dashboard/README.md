# vt/g-q-lreports

[![Build Status](https://img.shields.io/travis/com/vt/g-q-lreports/master.svg?style=for-the-badge&logo=travis)](https://travis-ci.com/vt/g-q-lreports) [![PHP Version](https://img.shields.io/packagist/php-v/vt/g-q-lreports.svg?style=for-the-badge)](https://github.com/vt/g-q-lreports) [![Stable Version](https://img.shields.io/packagist/v/vt/g-q-lreports.svg?style=for-the-badge&label=latest)](https://packagist.org/packages/vt/g-q-lreports)

## Usage

This assumes you have the OXID eShop up and running and installed and activated the `oxid-esales/graphql-base` module.

### Install
root composer.json ergänzen:
```
"autoload": {
  "psr-4": {
    "CodingDays\\Dashboard\\": "./source/modules/CodingDays/Dashboard/src"
  }
},
```
dann per SSH:
```bash
$ composer dump-autoload
$ cd source/modules/composer require vt/g-q-lreports
$ git clone https://github.com/CodeCommerce/CodingDays.git
$ cd ../../
$ ./vendor/bin/oe-console oe:module:install-configuration source/modules/CodingDays/Dashboard/
```
dann Modul aktivieren

### How to use

OrderCount by Date Diff

Query:
    Authentication:

    query {
        token (
        username: "usermail",
        password: "password"
        )
    }

Set Header from response

Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c


    query {
        reportCountByDateDiff(
          dateBetween: {
            between:[
              "2021-04-10",
              "2021-04-22 17:00:00"
            ]
          }
        )
    }

## Umsätze
```
query {
    revenue (
        from: "2021-04-01",
        to: "2021-04-31"
    ) {
        min
        avg
        max
        total
        paid
        unpaid
    }
}
```
Ohne Filter = ohne Eingrenzung

## Testing

### Linting, syntax, static analysis and unit tests

```bash
$ composer test
```

### Integration tests

- install this module into a running OXID eShop
- change the `test_config.yml`
  - add module to the `partial_module_paths`
  - set `activate_all_modules` to `true`

```bash
$ ./vendor/bin/runtests
```

## License

TBD
