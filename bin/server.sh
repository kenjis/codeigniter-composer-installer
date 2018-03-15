#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`/..

SERVER_HOST=${1:-127.0.0.1:8000}
SERVER_ROOT=${2:-public/}

php -S $SERVER_HOST -t $SERVER_ROOT/ -f bin/router.php
