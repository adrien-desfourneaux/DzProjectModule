#!/bin/sh

# /*!
#     Utilitaire pour la base de données de développement du module DzProject
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

function warn
{
	printf "Attention! Lancer ce script va supprimer la base de données de développement de DzProject ainsi que tout son contenu.\n";

	while true; do
	    read -p "Continuer ? " on
	    case $on in
	        [Oo]* ) break;;
	        [Nn]* ) exit;;
	        * ) echo "Repondre par oui ou non.";;
	    esac
	done
}

function create
{
	warn;
    rm -f dzproject.sqlite;
    cat dzproject.sqlite.sql | sqlite3 dzproject.sqlite;
    chmod g+w dzproject.sqlite
    CREATED=true
}

function dump
{
	if ! $CREATED; then create; fi
	cat dump.sqlite.sql | sqlite3 dzproject.sqlite;
	DUMPED=true
}

function help
{
	printf "Usage: db.sh create|dump\n";
	printf "create\tcre la base de donnees\n";
	printf "dump\tcre la base de donnees et y met les données de développement\n";
}

if [ $# -eq 0 ]; then
    help;
    exit;
fi;

# SCRIPTPATH = zf2_app/module/DzProject/data
SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
cd $SCRIPTPATH

CREATED=false
DUMPED=false

if [ "$1" = "create" ]; then create; fi
if [ "$1" = "dump" ]; then dump; fi