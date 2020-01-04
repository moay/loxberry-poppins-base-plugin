#!/bin/bash

echo "<INFO> Preparing vendor libraries"
php composer.phar install --no-interaction --no-dev
find ./data/vendor/composer/ -type f -name "*.php" | xargs sed -i "s+\$baseDir . '/data/+\$baseDir . '/+g"
find ./data/vendor/composer/ -type f -name "*.php" | xargs sed -i "s+__DIR__ . '/../../..' . '/data/+__DIR__ . '/../..' . '/+g"
find ./data/vendor/composer/ -type f -name "*.php" | xargs sed -i "s+\$baseDir = dirname(dirname(\$vendorDir))+\$baseDir = dirname(\$vendorDir)+g"
sed -i "s+'/data/src'+'/src'+g" ./data/vendor/composer/autoload_psr4.php
echo "<OK> Done installing vendor libraries"

echo "<INFO> Copying plugin configuration into installation"
cp ./plugin.cfg ./data/config/plugin.cfg
echo "<OK> Done copying plugin configuration"

# Exit with Status 0
exit 0
