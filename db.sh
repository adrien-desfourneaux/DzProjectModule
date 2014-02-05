#!/bin/sh

# /*!
#     Utilitaire de base de données
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

DBNAME=dzproject

# /*!
#     Change de répertoire vers le répertoire du script
#  */
cdscriptpath () {
  if [ -z $SCRIPTPATH ]; then
    SCRIPTPATH=$( cd "$(dirname "$0")" ; pwd -P )
    cd $SCRIPTPATH
  fi
}

# /*!
#     Affiche un message de confirmation
#  */
confirm () {
  while true; do
      read -p "Continuer ? " on
      case $on in
          [Oo]* ) break;;
          [Nn]* ) exit;;
          * ) echo "Repondre par oui ou non.";;
      esac
  done
}

# /*!
#     Cré les bases de données de test et de développement du module
#  */
create () { 
  cdscriptpath

  if [ -f data/$DBNAME.sqlite ]; then
    printf "Attention! Lancer ce script va supprimer la base de données de développement $DBNAME ainsi que tout son contenu.\n"
    confirm
    rm data/$DBNAME.sqlite
  fi

  cat data/$DBNAME.sqlite.sql | sqlite3 data/$DBNAME.sqlite
  chmod g+w data/$DBNAME.sqlite

  if [ ! -f tests/_data/$DBNAME.sqlite ]; then
    sqlite3 "" tests/_data/$DBNAME.sqlite
    chmod g+w tests/_data/$DBNAME.sqlite
  fi
}

# /*!
#     Remplit la base de données de développement du module
#     avec des données de test
#  */
dump () {
  create
  cat data/$DBNAME.dump.sqlite.sql | sqlite3 data/$DBNAME.sqlite
}

# /*!
#     Restaure les permissions des base de données
#     de test et de développement du module
#  */
perm () {
  cdscriptpath

  chmod 770 data
  if [ -f data/$DBNAME.sqlite ]; then chmod 660 data/$DBNAME.sqlite; fi
  if [ -d tests/_data ]; then chmod 770 tests/_data; fi
  if [ -f tests/_data/$DBNAME.sqlite ]; then chmod 660 tests/_data/$DBNAME.sqlite; fi
}

# /*!
#     Affiche un message d'aide
#  */
help () {
  printf "Usage: db.sh [action]\n"
  printf "help\taffiche cette aide\n"
  printf "create\tcre la base de donnees\n"
  printf "dump\tcre la base de donnees et y met les données de développement\n"
  printf "perm\trestaure les permissions des bases de données de test et développement\n"
}

if [ $# -eq 0 ]; then help
elif [ "$1" = "help" ]; then help
elif [ "$1" = "create" ]; then create
elif [ "$1" = "dump" ]; then dump
elif [ "$1" = "perm" ]; then perm
fi
