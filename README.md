Task Downloader Application [Laravel]
==================================

Requirements
------------

  * PHP 7.1.3 or higher;
  * and the [Laravel Server Requirements][1].

Installation
------------

Execute these commands to install the project:

```bash
$ cd Task-Downloader/
$ composer install
$ php artisan migrate
```

Create mysql database and add the database settings to .env file.

Usage
-----

Run the built-in web server and access the application in your browser at <http://localhost:8000>:

```bash
$ cd Task-Downloader/
$ php artisan serve
$ php artisan queue:work --tries=3
```

Tests
-----

Create mysql TEST database and setup the .env.testing file. Execute these commands to run tests (you must run acceptance tests with the server running):

```bash
$ cd Task-Downloader/
$ php artisan serve
$ ./vendor/bin/phpunit
```

Quick notes:
------------

1. List tasks

web: http://127.0.0.1:8000/tasks

api: curl http://127.0.0.1:8000/api/tasks

console: php artisan tasks:list

2. Add new task

web: http://127.0.0.1:8000/tasks/add

api: curl -i -d "url=http://phpsec.org/images/phpsc-logo.gif" -X POST http://127.0.0.1:8000/api/tasks

console: php artisan task:add http://phpsec.org/images/phpsc-logo.gif

3. Download task

web: http://127.0.0.1:8000/tasks/37/download

api: curl http://127.0.0.1:8000/api/tasks/37/download > somedoc.txt

console: php artisan task:download 37 > somedoc.txt


[1]: https://laravel.com/docs/5.7#server-requirements
