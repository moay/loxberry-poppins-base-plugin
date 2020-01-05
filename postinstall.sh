#!/bin/bash

PDIR=$3
PHTML=$LBPHTML/$PDIR

echo "<INFO> Copying .htaccess files to target location"
cp ./webfrontend/html/.htaccess $PHTML/html/.htaccess
cp ./webfrontend/htmlauth/.htaccess $PHTML/htmlauth/.htaccess

echo "<OK> Done copying .htaccess files"

# Exit with Status 0
exit 0
