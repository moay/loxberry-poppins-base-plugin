#!/bin/bash

PDIR=$3
PHTML=$LBPHTML/$PDIR
PHTMLAUTH=$LBPHTMLAUTH/$PDIR

echo "<INFO> Copying .htaccess files to target location"
cp ./webfrontend/html/.htaccess $PHTML/.htaccess
cp ./webfrontend/htmlauth/.htaccess $PHTMLAUTH/.htaccess

echo "<OK> Done copying .htaccess files"

# Exit with Status 0
exit 0
