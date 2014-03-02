# Migraine

Yet another tool for managing migrations.

## Requirements

Migraine requires PHP 5.4+ 

<small>Although some commands rely on features introduced with PHP 5.4, it will mostly work fine on PHP 5.3 too.</small>

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

## Reporting an issue or a feature request

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/jiabin/migraine/issues).

## Build

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
