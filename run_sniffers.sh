#!/bin/sh

# /*!
#     Run all sniffers for the DzProject module.
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH
../../vendor/bin/phpcs --standard="./phpcs.xml" --ignore="/doc/" --extensions="php,phtml" .
../../vendor/bin/phpmd . text ./phpmd.xml --exclude "doc,tests*Guy.php" --suffixes "php,phtml"
