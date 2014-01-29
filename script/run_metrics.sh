#!/bin/sh

# /*!
#     Lance la génération des métriques pour le module DzProject
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

# SCRIPTPATH = zf2_app/module/DzProject/script
SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH/..
mkdir -p metrics
../../vendor/bin/pdepend --summary-xml="metrics/summary.xml" \
                         --jdepend-chart="metrics/jdepend.svg" \
                         --overview-pyramid="metrics/pyramid.svg" \
                         .
../../vendor/bin/phploc --progress . > metrics/stats.txt
