# CodeIgniter Composer Installer

This package installs the offical [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) (branch `master`) with secure folder structure via Composer.

You can update CodeIgniter system folder to latest version with one command.

## Folder Structure

```
codeigniter/
├── application/
├── composer.json
├── composer.lock
├── public/
│   └── index.php
└── vendor/
    └── codeigniter/
        └── framework/
            └── system/
```

## Requirements

* composer command
* Git

## How to Use

### Install CodeIgniter

```
$ composer create-project kenjis/codeigniter-composer-installer codeigniter
```

### Run PHP built-in server

```
$ cd /path/to/codeigniter
$ php -S localhost:8000 -t public/
```

### Update CodeIgniter

```
$ cd /path/to/codeigniter
$ composer update
```

You must update files manually if files in `application` folder or `index.php` change.
