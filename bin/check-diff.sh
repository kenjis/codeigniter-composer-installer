#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`
cd ..

diff -urN vendor/codeigniter/framework/application application
diff -u vendor/codeigniter/framework/public public
diff -u vendor/codeigniter/framework/writable writable
diff -u vendor/codeigniter/framework/tests tests

diff -u vendor/codeigniter/framework/ci.php ci.php
diff -u vendor/codeigniter/framework/rewrite.php rewrite.php
diff -u vendor/codeigniter/framework/serve.php serve.php
diff -u vendor/codeigniter/framework/phpunit.xml.dist phpunit.xml.dist
