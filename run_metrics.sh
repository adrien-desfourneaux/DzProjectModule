#!/bin/sh

# /*!
#     Run metrics generation for the DzProject module.
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH
../../vendor/bin/pdepend --summary-xml="metrics/summary.xml" \
                         --jdepend-chart="metrics/jdepend.svg" \
                         --overview-pyramid="metrics/pyramid.svg" \
                         .
