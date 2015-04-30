#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`

user="jenssegers"
repos="codeigniter-hmvc-modules"

if [ $# -eq 0 ]; then
    echo "Install CodeIgniter HMVC Modules ($user/$repos)"
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
    cp -rf "$repos-$version/core/" ../application/core/
    cp -rf "$repos-$version/third_party/" ../application/third_party/
else
    cp -rf "$repos-$version/core/" -T ../application/core/
    cp -rf "$repos-$version/third_party/" -T  ../application/third_party/
fi

rm "$zip"
rm -rf "$repos-$version"
