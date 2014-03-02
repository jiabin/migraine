# Migraine

Yet another tool for managing migrations.

# Install

    curl -sS http://jiabin.github.io/migraine/installer | /bin/bash

# Launch

    php migraine.phar

# Build

You will need:
* [box](http://box-project.org) 
* [jsawk](https://github.com/micha/jsawk) 

First you need to install composer packages:

```
composer install
```

Once you have installed all required dependencies run:

```
box build
```

to build a phar file. Then you can launch the app by: 

```
./migraine.phar
```
