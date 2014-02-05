#!/bin/sh

# /*!
#     Utilitaire pour la base de données de développement du module DzProject
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

function cdscriptpath
{
  # SCRIPTPATH = zf2_app/module/DzProject/data
  SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
  cd $SCRIPTPATH
}

function confirm
{
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
  cdscriptpath;

  if [ -f dzproject.sqlite ]; then
    printf "Attention! Lancer ce script va supprimer la base de données de développement de DzProject ainsi que tout son contenu.\n";
    confirm;
      
      rm dzproject.sqlite;
    fi
    
    cat dzproject.sqlite.sql | sqlite3 dzproject.sqlite;
    chmod g+w dzproject.sqlite
}

function dump
{
  create;

  cdscriptpath;

  cat dzproject.dump.sqlite.sql | sqlite3 dzproject.sqlite;
}

function perm
{
  cdscriptpath;

  chmod 770 ../data
  if [ -f dzproject.sqlite ]; then chmod 660 dzproject.sqlite; fi

  if [ -d ../tests/_data ]; then chmod 770 ../tests/_data; fi
  if [ -f ../tests/_data/dzproject.sqlite ]; then chmod 660 ../tests/_data/dzproject.sqlite; fi
}

function help
{
  printf "Usage: db.sh [action]\n";
  printf "help\taffiche cette aide\n"
  printf "create\tcre la base de donnees\n";
  printf "dump\tcre la base de donnees et y met les données de développement\n";
  printf "perm\trestaure les permissions des bases de données de test et développement\n"
}

if [ $# -eq 0 ]; then help; fi
if [ "$1" = "help" ]; then help; fi
if [ "$1" = "create" ]; then create; fi
if [ "$1" = "dump" ]; then dump; fi
if [ "$1" = "perm" ]; then perm; fi
