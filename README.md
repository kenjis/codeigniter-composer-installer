# CodeIgniter Composer Installer

[![Latest Stable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/stable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Total Downloads](https://poser.pugx.org/kenjis/codeigniter-composer-installer/downloads)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Latest Unstable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/unstable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![License](https://poser.pugx.org/kenjis/codeigniter-composer-installer/license)](https://packagist.org/packages/kenjis/codeigniter-composer-installer)

This package installs the offical [CodeIgniter4](https://github.com/bcit-ci/CodeIgniter4) (version `dev-develop`) via Composer.

You can update CodeIgniter system folder to latest version with one command.

## Folder Structure

```
codeigniter/
├── application/
├── composer.json
├── composer.lock
├── public/
│   ├── .htaccess
│   └── index.php
└── vendor/
    └── codeigniter/
        └── framework/
            └── system/
```

## Requirements

* PHP 7.0 or later
* `composer` command (See [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx))
* Git

## How to Use

### Install CodeIgniter

```
$ composer create-project kenjis/codeigniter-composer-installer:4.x-dev codeigniter4
```

### Run PHP built-in server 

```
$ cd /path/to/codeigniter
$ bin/server.sh
```

### Update CodeIgniter

```
$ cd /path/to/codeigniter
$ composer update
```

You must update files manually if files in `application` or `public` folder change. Check [CodeIgniter4 User Guide](https://bcit-ci.github.io/CodeIgniter4/installation/upgrading.html).

## Reference

* [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* [CodeIgniter4](https://github.com/bcit-ci/CodeIgniter4)
* [CodeIgniter4 User Guide](https://bcit-ci.github.io/CodeIgniter4/)
