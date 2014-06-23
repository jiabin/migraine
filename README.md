![Mind Blowing by Luis Prado from The Noun Project](doc/logo.png) Migraine
==========================================================================

Migraine is a PHP-based command-line utility for simplifying the process of creating/executing migrations.

## Requirements

The only requirement for Migraine is PHP 5.4+

## Install

```
curl -sS http://jiabin.github.io/migraine/installer | /bin/bash
```
## Quick start

**Show all available commands**

```
php migraine.phar
```

**Migrate to the latest version**

```
php migraine.phar migrate
```

**Create a new migration**

```
php migraine.phar create
```

**Print version and exit**

```
php migraine.phar -V
```

## Commands reference

| command           | description                                   |
|----------------   |---------------------------------------------- |
| create            | Creates a new migration                       |
| dump-reference    | Dumps the default configuration for Migraine  |
| help              | Displays help for a command                   |
| init              | Creates a new configuration file              |
| list              | Lists commands                                |
| migrate           | Execute migrations                            |
| reset             | Reset migraine                                |
| self-update       | Updates migraine.phar to the latest version   |
| status            | Shows migration status                        |

## Supported types

* file
* mongo
* redis

## Supported bridges

### 1) Composer

#### Configuration reference

| option            | default                                       |
|----------------   |---------------------------------------------- |
| autoload          | vendor/autoload.php                           |

### 2) Symfony

#### Configuration reference

| option            | default                                       |
|----------------   |---------------------------------------------- |
| bootstrap         | app/bootstrap.php.cache                       |
| kernel            | app/AppKernel.php                             |
| env               | dev                                           |
| debug             | false                                         |

## Sample configuration (migraine.yml)

```
# Migrations will be stored and read from this path
migrations_path:      ./migrations

# Number of "zeros" to append to version
pad_length:           3

# Application bridge
bridge:

    # One of "composer"; "symfony"
    name:                 composer # Required

    # Bridge options
    options:
        autoload: vendor/autoload.php

# Type configuration
types:
    file:
        lock_file:            migraine.lock
    # redis:
    #     host:                 'tcp://localhost:6379'
    #     prefix:               null
    # mongo:
    #     server:               'mongodb://localhost:27017'
    #     database:             migraine
```

## Reporting an issue or a feature request

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/jiabin/migraine/issues).

## Contributing

First you need to install composer dependencies:

```
composer install
```

Now you can run migraine by:

```
./bin/migraine
``` 

To build a phar file you will need [box](http://box-project.org) 

```
box build
```

Then you can launch the app by: 

```
./migraine.phar
```
