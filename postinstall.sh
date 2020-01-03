#!/bin/bash

echo "<INFO> Installing vendor libraries"
php composer.phar install --no-interaction

# Exit with Status 0
exit 0
