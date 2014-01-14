#!/bin/sh

# /*!
#     Run all tests for the DzProject module.
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH
../../vendor/bin/phpspec run
../../vendor/bin/codecept run
