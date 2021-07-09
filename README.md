# Falcon
## _Project training_
### Basic
#### Clone project: 
```sh
    $ git clone ...
```

#### Install project
```sh
    $ composer install
    $ php artisan key:generate
    $ php artisan serve // server start with port 8000
```
- test php
```sh
    $ vendor/bin/phpcs --standard=phpcs.xml
```

### Using Makefile: < using for Linux and macos>
- install and start project
```sh
    $ make init
```
- start  project
```sh
    $ make start
```
- test php
```sh
    $ make testphp
```
