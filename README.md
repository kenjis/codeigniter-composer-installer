# CodeIgniter Composer Installer

[![Latest Stable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/stable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Total Downloads](https://poser.pugx.org/kenjis/codeigniter-composer-installer/downloads)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Latest Unstable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/unstable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![License](https://poser.pugx.org/kenjis/codeigniter-composer-installer/license)](https://packagist.org/packages/kenjis/codeigniter-composer-installer)

This package installs the offical [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) (version `3.0.*`) with secure folder structure via Composer.

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

* PHP 5.3.2 or later
* `composer` command
* Git

## How to Use

### Install CodeIgniter

```
$ composer create-project kenjis/codeigniter-composer-installer codeigniter
```

#### Optional

If you want to install translations for system messages (requires shell):

```
$ bin/install-translations.sh
```

If you want to install Codeigniter Matches CLI (requires shell):

```
$ bin/install-codeigniter-matches-cli.sh
```

### Run PHP built-in server (PHP 5.4 or later)

```
$ cd /path/to/codeigniter
$ php -S localhost:8000 -t public/ bin/router.php
```

### Update CodeIgniter

```
$ cd /path/to/codeigniter
$ composer update
```

You must update files manually if files in `application` folder or `index.php` change.

## Reference

* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [Translations for CodeIgniter System](https://github.com/bcit-ci/codeigniter3-translations)
* [Codeigniter Matches CLI](https://github.com/avenirer/codeigniter-matches-cli)

## Related

* [Cli for CodeIgniter 3.0](https://github.com/kenjis/codeigniter-cli)
