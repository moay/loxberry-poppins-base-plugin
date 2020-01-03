#!/bin/bash

PDIR=$3
PDATA=$LBPDATA/$PDIR
TARGETDIR=$PDATA/vendor

echo "<INFO> Preparing vendor libraries"
php composer.phar install --no-interaction --no-dev

echo "<INFO> Copying vendor libraries to $TARGETDIR"
rm -rf $TARGETDIR
mv ./data/vendor/* $TARGETDIR

echo "<SUCCESS> Done installing vendor libraries"

# Exit with Status 0
exit 0
