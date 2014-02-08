#!/bin/bash

# /*!
#     Script d'assurance qualité (Quality Assurance)
#     Vérifie la qualité du code
#     @author Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
#  */

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
#     Lance les tests de spécification
#  */
runspec () {
    cdscriptpath
    ../../vendor/bin/phpspec run
}

# /*!
#     Lance les tests d'acceptation
#  */
runcept () {
    cdscriptpath
    ../../vendor/bin/codecept run
}

# /*!
#     Lance le code sniffer
#  */
runcodesniffer () {
    cdscriptpath
    ../../vendor/bin/phpcs --standard="phpcs.xml" --ignore="/doc/" --extensions="php,phtml" .

    exclude="^\./(\.git/|doc/|.*_log/|.*\.DS_Store$|.*\.png$|.*\.jar$|.*\.sqlite$).*"

    # Search for unwanted tab characters
    if uname | grep "Linux" > /dev/null; then
        find . -regextype posix-extended -not -regex "$exclude" | xargs grep $'\t' -sl | awk '{print "Tab characters in "$1}'
    elif uname | grep "Darwin" > /dev/null; then
        find -E . -not -regex "$exclude" | xargs grep "\t" -sl | awk '{print "Tab characters in "$1}'
    else
        echo "Impossible de détecter les caractères tabs\n" 1>&2
        return 1
    fi
}

# /*!
#     Lance le mess detector
#  */
runmessdetector () {
    cdscriptpath
    ../../vendor/bin/phpmd . text phpmd.xml --exclude "doc,tests*Guy.php" --suffixes "php,phtml"
}

# /*!
#     Lance le copy-paste detector
#  */
runcpdetector () {
    cdscriptpath
    ../../vendor/bin/phpcpd --progress .
}

# /*!
#     Génère les statistiques du module
#  */
genstats () {
    cdscriptpath
    mkdir -p metrics
    ../../vendor/bin/phploc --progress . > metrics/stats.txt
}

# /*!
#     Génère les métriques du module
#  */
gendepend () {
    cdscriptpath
    mkdir -p metrics
    ../../vendor/bin/pdepend --summary-xml="metrics/summary.xml" \
        --jdepend-chart="metrics/jdepend.svg" \
        --overview-pyramid="metrics/pyramid.svg" \
        .
}

# /*!
#     Génére la documentation du module
#  */
gendoc () {
    cdscriptpath
    mkdir -p doc
    ../../vendor/bin/phpdoc.php run -d . -t doc
}

# /*!
#     Vérifie la documentation (docblocks) du module
#  */
checkdoc () {
    cdscriptpath

    Category="(\<Config\>|\<Autoload\>|\<Source\>|\<Spec\>|\<Test\>)$"
    Package="\<DzProject(/.*|\>)"
    Author="Adrien Desfourneaux \(aka Dieze\) <dieze51@gmail\.com>$"
    License="\shttp://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2$"
    Link="\<https://github.com/dieze/DzProject/blob/master/.+"
    exclude=".*tests.*Guy.php$"

    find . \( -name "*.php" -o -name "*.phtml" \) -and -not -regex "$exclude" | xargs grep -E -sL "@category\s+${Category}" | awk '{print "Wrong or no category in "$1}'
    find . \( -name "*.php" -o -name "*.phtml" \) -and -not -regex "$exclude" | xargs grep -E -sL "@package\s+${Package}" | awk '{print "Wrong or no package name in "$1}'
    find . \( -name "*.php" -o -name "*.phtml" \) -and -not -regex "$exclude" | xargs grep -E -sL "@author\s+${Author}" | awk '{print "Wrong or no author in "$1}'
    find . \( -name "*.php" -o -name "*.phtml" \) -and -not -regex "$exclude" | xargs grep -E -sL "@license\s+${License}" | awk '{print "Wrong or no license in "$1}'
    find . \( -name "*.php" -o -name "*.phtml" \) -and -not -regex "$exclude" | xargs grep -E -sL "@link\s+${Link}" | awk '{print "Wrong or no link in "$1}'
}

# /*!
#     Lance toutes les commandes
#  */
runall () {
    # test
    runspec
    runcept

    # analyse
    runcodesniffer
    runmessdetector
    runcpdetector

    # metric
    genstats
    gendepend

    # doc
    gendoc
    checkdoc
}

# /*!
#     Affiche l'aide
#  */
help () {
    printf "Usage: qa.sh [command]\n"
    printf "help\t\taffiche cette aide\n"
    printf "help [command]\taffiche l'aide de la commande\n"
    printf "test\t\tgestion des tests du module\n"
    printf "analyse\t\tanalyse la structure et la syntaxe du code\n"
    printf "metric\t\tanalyse la métrique du code\n"
    printf "doc\t\tgestion de la documentation du module\n"
    printf "all\t\tlance toutes les commandes\n"
    printf "\naffiche cette aide si aucune action n'est spécifiée\n"
}

# /*!
#     Affiche l'aide de test
#  */
helptest () {
    printf "Usage: qa.sh test [arg]\n"
    printf "spec\tLance les tests de spécification\n"
    printf "cept\tLance les tests d'acceptation\n"
}

# /*!
#      Affiche l'aide de analyse
#  */
helpanalyse () {
    printf "Usage: qa.sh analyse [arg]\n"
    printf "code\tvéfifie la syntaxe du code\n"
    printf "mess\trecherche des problmes potentiels dans le code\n"
    printf "cp\trecherche des traces de copier-coller dans le code\n"
    printf "\nLance tous les arguments si aucun n'est spécifié\n"
}

# /*!
#     Affiche l'aide de metric
#  */
helpmetric () {
    printf "Usage: qa.sh metric [arg]\n"
    printf "depend\tGénère des diagramme de dépendances du code\n"
    printf "stats\tGénère des statistiques sur le code\n"
    printf "\nLance tous les arguments si aucun n'est spécifié\n"
}

# /*!
#     Affiche l'aide de doc
#  */
helpdoc () {
    printf "Usage: qa.sh doc [action]\n"
    printf "check\tvérifie les blocs de documentation de code\n"
    printf "gen\tgénère la documentation du module\n"
    printf "\nLance toutes les actions si aucune n'est spécifiée\n"
}

# no argument
if [ $# -eq 0 ]; then help

    # help
elif [ $1 = 'help' ]; then
    if [ $# -eq 1 ]; then help
    elif [ $2 = 'test' ]; then helptest
    elif [ $2 = 'analyse' ]; then helpanalyse
    elif [ $2 = 'metric' ]; then helpanalyse
    elif [ $2 = 'doc' ]; then helpdoc
    fi

    # test
elif [ $1 = 'test' ]; then
    if [ $# -eq 1 ]; then runspec; runcept
    elif [ $2 = 'spec' ]; then runspec
    elif [ $2 = 'cept' ]; then runcept
    else helptest
    fi

    # analyse
elif [ $1 = 'analyse' ]; then
    if [ $# -eq 1 ]; then runcodesniffer; runmessdetector; runcpdetector
    elif [ $2 = 'code' ]; then runcodesniffer
    elif [ $2 = 'mess' ]; then runmessdetector
    elif [ $2 = 'cp' ]; then runcpdetector
    else helpanalyse
    fi

    # metric
elif [ $1 = 'metric' ]; then
    if [ $# -eq 1 ]; then gendepend; genstats
    elif [ $2 = 'depend' ]; then gendepend
    elif [ $2 = 'stats' ]; then genstats
    else helpmetric
    fi

    # doc
elif [ $1 = 'doc' ]; then
    if [ $# -eq 1 ]; then checkdoc; gendoc
    elif [ $2 = 'check' ]; then checkdoc
    elif [ $2 = 'gen' ]; then gendoc
    else helpdoc
    fi

    # all
elif [ $1 = 'all' ]; then runall;

    # help
else help;

fi
