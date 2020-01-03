#!/bin/bash

echo "<INFO> Installing vendor libraries"
php composer.phar install --no-interaction --no-dev

PDATA=$LBPDATA/$PDIR
TARGETDIR=$PDATA/vendor
echo "<INFO> Copying vendor libraries to $TARGETDIR"
if [ -f TARGETDIR ] ; then
    rm TARGETDIR
fi
mv ./data/vendor/* TARGETDIR

# Exit with Status 0
exit 0
