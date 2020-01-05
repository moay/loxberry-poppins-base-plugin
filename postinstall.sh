#!/bin/bash

PDIR=$3
PTEMPL=$LBPTEMPL/$PDIR

echo "<INFO> Copying .htaccess files to target location"
cp ./webfrontend/html/.htaccess $PTEMPL/html/.htaccess
cp ./webfrontend/htmlauth/.htaccess $PTEMPL/htmlauth/.htaccess

echo "<OK> Done copying .htaccess files"

# Exit with Status 0
exit 0
