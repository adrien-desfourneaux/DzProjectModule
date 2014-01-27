#!/bin/sh

# /*!
#     Create db for DzProject module.
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

# SCRIPTPATH = zf2_app/module/DzProject/script
SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH

function create_db
{
    rm -f dz-project.sqlite;
    cat dz-project.sqlite.sql | sqlite3 dz-project.sqlite;
}

printf "Warning! Running this script will delete the DzProject database and its content.\n";

while true; do
    read -p "Continue ? " yn
    case $yn in
        [Yy]* ) create_db; break;;
        [Nn]* ) exit;;
        * ) echo "Please answer yes or no.";;
    esac
done
