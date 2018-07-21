#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`
cd ..

rewrite="vendor/codeigniter4/framework/system/Commands/Server/rewrite.php"
sed -i -e '/^\$fcpath/c $fcpath = realpath(__DIR__ . '\''/../../../../../../public'\'') . DIRECTORY_SEPARATOR;' "$rewrite"

php spark serve
