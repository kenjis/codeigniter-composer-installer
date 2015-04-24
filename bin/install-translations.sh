#!/bin/sh

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
cp -rf "codeigniter3-translations-$version/language/" ../application/language/

rm translations.zip
rm -rf "codeigniter3-translations-$version"
