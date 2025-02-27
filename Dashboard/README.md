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

## How to use

### Bestellungen
#####Authentication Query:

    query {
        token (
        username: "usermail",
        password: "password"
        )
    }

##### Set Header from response - also the user has to be in oxidadmin user group

Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c

##### Get Ordercount between from and to date
##### Query:
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
Will return integer

##### Get Ordercount since x days
##### Query:
    query {
        reportCountLastDays(
          days: 20
        )
    }

Will return integer

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
