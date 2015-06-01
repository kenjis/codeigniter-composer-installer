#!/bin/sh

cd `dirname $0`
cd ..

# Install translations
php bin/install.php translations develop

# Install Codeigniter Matches CLI
php bin/install.php matches-cli master

# Install Cli for CodeIgniter
composer require kenjis/codeigniter-cli:1.0.x@dev --dev
php vendor/kenjis/codeigniter-cli/install.php

# Install CI PHPUnit Test
composer require kenjis/ci-phpunit-test:1.0.x@dev --dev
php vendor/kenjis/ci-phpunit-test/install.php

# Install CodeIgniter Simple and Secure Twig
composer require kenjis/codeigniter-ss-twig:1.0.x@dev
php vendor/kenjis/codeigniter-ss-twig/install.php

# Install CodeIgniter Deployer
composer require phpseclib/phpseclib:dev-master#2c96af214bf1b5e29b707249108504b4e0041a21
composer require kenjis/codeigniter-deployer:1.0.x@dev --dev
php vendor/kenjis/codeigniter-deployer/install.php
