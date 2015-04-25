#!/bin/sh

## Part of CodeIgniter Composer Installer
##
## @author     Kenji Suzuki <https://github.com/kenjis>
## @license    MIT License
## @copyright  2015 Kenji Suzuki
## @link       https://github.com/kenjis/codeigniter-composer-installer

cd `dirname $0`

if [ $# -eq 0 ]; then
    echo "Install Translations for CodeIgniter System Messages"
    echo " usage: $0 <version>"
    echo "    eg: $0 master"
    exit
fi

version="$1"

curl -L -o translations.zip "https://github.com/bcit-ci/codeigniter3-translations/archive/$version.zip"
unzip translations.zip

OS=`uname`
if [ "$OS" = "Darwin" ]; then
    cp -rf "codeigniter3-translations-$version/language/" ../application/language/
else
    cp -rf "codeigniter3-translations-$version/language/" -T ../application/language/
fi

rm translations.zip
rm -rf "codeigniter3-translations-$version"
