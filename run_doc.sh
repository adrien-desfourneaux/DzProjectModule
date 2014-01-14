#!/bin/sh

# /*!
#     Run documentation generation for the DzProject module.
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH
../../vendor/bin/phpdoc.php run -d . -t doc
