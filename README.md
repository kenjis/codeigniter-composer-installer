# CodeIgniter Composer Installer

[![Latest Stable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/stable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Total Downloads](https://poser.pugx.org/kenjis/codeigniter-composer-installer/downloads)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![Latest Unstable Version](https://poser.pugx.org/kenjis/codeigniter-composer-installer/v/unstable)](https://packagist.org/packages/kenjis/codeigniter-composer-installer) [![License](https://poser.pugx.org/kenjis/codeigniter-composer-installer/license)](https://packagist.org/packages/kenjis/codeigniter-composer-installer)

This package installs the offical [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) (version `3.1.*`) with secure folder structure via Composer.

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

* PHP 5.3.7 or later
* `composer` command (See [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx))
* Git

## How to Use

### Install CodeIgniter

```
$ composer create-project kenjis/codeigniter-composer-installer codeigniter
```

Above command installs `public/.htaccess` to remove `index.php` in your URL. If you don't need it, please remove it.

And it changes `application/config/config.php`:

~~~
$config['composer_autoload'] = FALSE;
↓
$config['composer_autoload'] = realpath(APPPATH . '../vendor/autoload.php');
~~~

~~~
$config['index_page'] = 'index.php';
↓
$config['index_page'] = '';
~~~

#### Install Translations for System Messages

If you want to install translations for system messages:

```
$ cd /path/to/codeigniter
$ php bin/install.php translations 3.1.0
```

#### Install Third Party Libraries

[Codeigniter Matches CLI](https://github.com/avenirer/codeigniter-matches-cli):

```
$ php bin/install.php matches-cli master
```

[CodeIgniter HMVC Modules](https://github.com/jenssegers/codeigniter-hmvc-modules):

```
$ php bin/install.php hmvc-modules master
```

[Modular Extensions - HMVC](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc):

```
$ php bin/install.php modular-extensions-hmvc codeigniter-3.x
```

[Ion Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth):

```
$ php bin/install.php ion-auth 2
```

[CodeIgniter3 Filename Checker](https://github.com/kenjis/codeigniter3-filename-checker):

```
$ php bin/install.php filename-checker master
```

[CodeIgniter Rest Server](https://github.com/chriskacerguis/codeigniter-restserver):

```
$ php bin/install.php restserver 2.7.2
```

### Run PHP built-in server (PHP 5.4 or later)

```
$ bin/server.sh
```

### Update CodeIgniter

```
$ cd /path/to/codeigniter
$ composer update
```

You must update files manually if files in `application` folder or `index.php` change. Check [CodeIgniter User Guide](http://www.codeigniter.com/user_guide/installation/upgrading.html).

## Reference

* [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [Translations for CodeIgniter System](https://github.com/bcit-ci/codeigniter3-translations)

## Related Projects for CodeIgniter 3.0

* [Cli for CodeIgniter 3.0](https://github.com/kenjis/codeigniter-cli)
* [ci-phpunit-test](https://github.com/kenjis/ci-phpunit-test)
* [CodeIgniter Simple and Secure Twig](https://github.com/kenjis/codeigniter-ss-twig)
* [CodeIgniter Doctrine](https://github.com/kenjis/codeigniter-doctrine)
* [CodeIgniter Deployer](https://github.com/kenjis/codeigniter-deployer)
* [CodeIgniter3 Filename Checker](https://github.com/kenjis/codeigniter3-filename-checker)
* [CodeIgniter Widget (View Partial) Sample](https://github.com/kenjis/codeigniter-widgets)
