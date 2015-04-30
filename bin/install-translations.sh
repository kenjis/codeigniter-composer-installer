#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`

user="bcit-ci"
repos="codeigniter3-translations"

if [ $# -eq 0 ]; then
    echo "Install Translations for CodeIgniter System Messages ($user/$repos)"
    echo " usage: $0 <version/branch>"
    echo "    eg: $0 3.0.0"
    echo "    eg: $0 master"
    exit
fi

version="$1"
zip="tmp-$$.zip"

curl -L -o "$zip" "https://github.com/$user/$repos/archive/$version.zip"
unzip "$zip"

OS=`uname`
if [ "$OS" = "Darwin" ]; then
    cp -rf "$repos-$version/language/" ../application/language/
else
    cp -rf "$repos-$version/language/" -T ../application/language/
fi

rm "$zip"
rm -rf "$repos-$version"
