Database shell command
======================

Add an Artisan command, `db:shell`, which invokes a database shell on a 
configured database connection.

Binaries for the various database shells are expected to be in your path.

Laravel version
---------------

This branch and the `v1.*` line of tags are for Laravel 4. For the Laravel 5
version [see the laravel5 branch][l5] and the `v2.*` line of tags.

[l5]: https://github.com/tremby/laravel-db-shell-command/tree/laravel5

Installation
------------

Require it in your Laravel project:

    composer require tremby/laravel-db-shell-command

Add a line to your `app/start/artisan.php` file to register the command:

    Artisan::add(new Tremby\DbShellCommand\DbShellCommand);

Use
---

A new Artisan command is added; it will be listed in

    ./artisan list

See the help text for options:

    ./artisan db:shell --help

To launch a shell for the application's default database (in the current 
environment), just run

    ./artisan db:shell

Supported database drivers
--------------------------

- mysql

Pull requests are welcome for others.
