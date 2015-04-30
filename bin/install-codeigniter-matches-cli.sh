#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`

user="avenirer"
repos="codeigniter-matches-cli"

if [ $# -eq 0 ]; then
    echo "Install Codeigniter Matches CLI ($user/$repos)"
    echo " usage: $0 <branch>"
    echo "    eg: $0 master"
    exit
fi

version="$1"
zip="tmp-$$.zip"

curl -L -o "$zip" "https://github.com/$user/$repos/archive/$version.zip"
unzip "$zip"

OS=`uname`
if [ "$OS" = "Darwin" ]; then
    cp -rf "$repos-$version/config/" ../application/config/
    cp -rf "$repos-$version/controllers/" ../application/controllers/
    cp -rf "$repos-$version/views/" ../application/third_party/
else
    cp -rf "$repos-$version/config/" -T ../application/config/
    cp -rf "$repos-$version/controllers/" -T  ../application/controllers/
    cp -rf "$repos-$version/views/" -T ../application/third_party/
fi

rm "$zip"
rm -rf "$repos-$version"
