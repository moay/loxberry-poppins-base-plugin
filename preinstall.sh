#!/bin/bash

echo "<INFO> Copying plugin configuration into installation"
cp ./plugin.cfg ./config/plugin.cfg
echo "<OK> Done copying plugin configuration"

echo "<INFO> Preparing vendor libraries"
php composer.phar install --no-interaction --no-dev --no-progress
php composer.phar dump-autoload
echo "<OK> Done installing vendor libraries"

echo "<INFO> Moving all translation files to templates folder"
mkdir -p ./resources/templates/lang
find ./translations/*.ini -maxdepth 0 ! -name . ! -name .. -print -exec mv {} ./resources/templates/lang/ \;
rm -rf ./translations

echo "<INFO> Moving all code folders to data"
cp ./config/plugin.cfg ./plugin.cfg
mkdir ./data
find . -type d -maxdepth 1 ! -name "data" ! -name "resources" ! -name . -print -exec mv {} ./data \;

echo "<INFO> Moving all resource folders and files to plugin root"
find ./resources/* -maxdepth 0 ! -name . ! -name .. -print -exec mv {} ./ \;
rm -rf ./resources

echo "<OK> Done moving files and folders."
echo "<INFO> Ready for installation."

# Exit with Status 0
exit 0
