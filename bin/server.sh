#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`
cd ..

SERVER_HOST_AND_PORT=${1:-127.0.0.1:8000}
SERVER_HOST=${SERVER_HOST_AND_PORT%:*}
SERVER_PORT=${SERVER_HOST_AND_PORT##*:}

php spark serve -host $SERVER_HOST -port $SERVER_PORT
