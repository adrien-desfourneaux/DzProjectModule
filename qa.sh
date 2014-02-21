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
    ../../vendor/bin/codecept run --steps
}

# /*!
#     Définit les fixers à utiliser pour le php-cs-fixer
#  */
setphpcsfixers () {
    #indentation [PSR-2] Code must use 4 spaces for indenting, not tabs.
    fixers="indentation"
    # linefeed [PSR-2] All PHP files must use the Unix LF (linefeed) line ending.
    fixers="$fixers,linefeed"
    # trailing_spaces [PSR-2] Remove trailing whitespace at the end of lines.
    fixers="$fixers,trailing_spaces"
    # unused_use [all] Unused use statements must be removed.
    fixers="$fixers,unused_use"
    # phpdoc_params [all] All items of the @param phpdoc tags must be aligned vertically.
    fixers="$fixers,phpdoc_params"
    # short_tag [PSR-1] PHP code must use the long <?php ?> tags or the short-echo <?= ?> tags; it must not use the other tag variations.
    fixers="$fixers,short_tag"
    # return [all] An empty line feed should precede a return statement.
    fixers="$fixers,return"
    # visibility [PSR-2] Visibility must be declared on all properties and methods; abstract and final must be declared before the visibility; static must be declared after the visibility.
    fixers="$fixers,visibility"
    # php_closing_tag [PSR-2] The closing ?> tag MUST be omitted from files containing only PHP.
    fixers="$fixers,php_closing_tag"
    # braces [PSR-2] Opening braces for classes, interfaces, traits and methods must go on the next line, and closing braces must go on the next line after the body. Opening braces for control structures must go on the same line, and closing braces must go on the next line after the body.
    fixers="$fixers,braces"
    # extra_empty_lines [all] Removes extra empty lines.
    fixers="$fixers,extra_empty_lines"
    # function_declaration [PSR-2] Spaces should be properly placed in a function declaration
    fixers="$fixers,function_declaration"
    # include [all] Include and file path should be divided with a single space. File path should not be placed under brackets.
    fixers="$fixers,include"
    # controls_spaces [all] A single space should be between: the closing brace and the control, the control and the opening parentheses, the closing parentheses and the opening brace.
    fixers="$fixers,controls_spaces"
    # psr0 [PSR-0] Classes must be in a path that matches their namespace, be at least one namespace deep, and the class name should match the file name.
    # Do not use this fixer
    fixers="$fixers,-psr0"
    # elseif [PSR-2] The keyword elseif should be used instead of else if so that all control keywords looks like single words.
    fixers="$fixers,elseif"
    # eof_ending [PSR-2] A file must always end with an empty line feed.
    fixers="$fixers,eof_ending"
}

# /*!
#     Lance le code sniffer
#     2 code sniffers sont utilisés : PHP_CodeSniffer et php-cs-fixer (PHP Coding Standards Fixer)
#  */
runcodesniffer () {
    cdscriptpath
    setphpcsfixers

    ../../vendor/bin/phpcs --standard="phpcs.xml" --ignore="/doc/" --extensions="php" .
    ../../vendor/bin/php-cs-fixer fix . --dry-run --verbose --fixers=$fixers
}

# /*!
#     Lance le code fixer
#  */
runcodefixer () {
    cdscriptpath
    setphpcsfixers

    ../../vendor/bin/php-cs-fixer fix . --verbose --fixers=$fixers
}

# /*!
#     Vérifie la présence d'indentation
#     avec des caractères tabs
#     
#     Cette fonction est dépréciée, ne plus l'utiliser
#     Utiliser php-cs-fixer (runcodesniffer ()) à la place
#  */ 
checktabindent () {
    exclude="^\./(\.git/|doc/|.*_log/|.*\.DS_Store$|.*\.png$|.*\.jar$|.*\.sqlite$).*"

    if uname | grep "Linux" > /dev/null; then
        find . -regextype posix-extended -not -regex "$exclude" | xargs grep $'^\t' -sl | awk '{print "Tab indent in "$1}'
    elif uname | grep "Darwin" > /dev/null; then
        find -E . -not -regex "$exclude" | xargs grep "^\t" -sl | awk '{print "Tab indent in "$1}'
    else
        echo "Impossible de détecter les indentations avec caractères tab\n" 1>&2
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
#     Deprécié
#  */
genstats () {
    cdscriptpath
    mkdir -p metrics
    ../../vendor/bin/phploc --progress . > metrics/stats.txt
}

# /*!
#     Affiche les statistiques du module
#  */
showstats () {
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
#     Génère le classmap pour l'autoloader
#  */
genclassmap () {
    cdscriptpath

    ../../vendor/bin/classmap_generator.php .
}

# /*!
#     Lance toutes les commandes
#  */
runall () {
    # test
    runspec
    runcept

    # code check
    runcodesniffer
    runmessdetector
    runcpdetector

    # code stats
    showstats

    # code depend
    gendepend

    # doc
    gendoc
    checkdoc

    # loader
    genclassmap
}

# /*!
#     Affiche l'aide
#  */
help () {
    printf "Usage: qa.sh [command]\n"
    printf "help\t\tAffiche cette aide\n"
    printf "help [command]\tAffiche l'aide de la commande\n"
    printf "test\t\tGestion des tests du module\n"
    printf "code\t\tGestion du code source\n"
    printf "doc\t\tGestion de la documentation du module\n"
    printf "loader\t\tGestion du loader du module\n"
    printf "all\t\tLance toutes les commandes\n"
    printf "\nAffiche cette aide si aucune action n'est spécifiée\n"
}

# /*!
#     Affiche l'aide de la gestion des test
#  */
helptest () {
    printf "Usage: qa.sh test [arg]\n"
    printf "spec\tLance les tests de spécification\n"
    printf "cept\tLance les tests d'acceptation\n"
}

# /*!
#      Affiche l'aide de la gestion du code
#  */
helpcode () {
    printf "Usage: qa.sh code [command]\n"
    printf "check\tVéfifie la conformité du code aux standards\n"
    printf "fix\tRésout les problèmes de conformité du code aux standards\n"
    printf "stats\tAffiche des statistiques sur le code\n"
    printf "depend\tGénère les diagrammes de dépendances de code\n"
    printf "\nLance tous les arguments si aucun n'est spécifié\n"
}

# /*!
#     Affiche l'aide de la gestion de la documentation
#  */
helpdoc () {
    printf "Usage: qa.sh doc [action]\n"
    printf "check\tvérifie les blocs de documentation de code\n"
    printf "gen\tGénère la documentation du module\n"
    printf "\nLance toutes les actions si aucune n'est spécifiée\n"
}

# /*!
#     Affiche l'aide de la gestion du loader du module
#  */
helploader () {
    printf "Usage: qa.sh loader [arg]\n"
    printf "classmap\tGénère le classmap pour l'autoload\n"
    printf "\nLance toutes les arguments si aucun n'est spécifié\n"
} 

# no argument
if [ $# -eq 0 ]; then help

# help
elif [ $1 = 'help' ]; then
    if [ $# -eq 1 ]; then help
    elif [ $2 = 'test' ]; then helptest
    elif [ $2 = 'code' ]; then helpcode
    elif [ $2 = 'doc' ]; then helpdoc
    elif [ $2 = 'loader' ]; then helploader
    else help
    fi

# test
elif [ $1 = 'test' ]; then
    if [ $# -eq 1 ]; then runspec; runcept
    elif [ $2 = 'spec' ]; then runspec
    elif [ $2 = 'cept' ]; then runcept
    else helptest
    fi

# code
elif [ $1 = 'code' ]; then
    if [ $# -eq 1 ]; then
        runcodesniffer
        runmessdetector
        runcpdetector
        showstats
        gendepend
    elif [ $2 = 'check' ]; then
        runcodesniffer
        runmessdetector
        runcpdetector
    elif [ $2 = 'fix' ]; then runcodefixer
    elif [ $2 = 'stats' ]; then showstats
    elif [ $2 = 'depend' ]; then gendepend
    else helpcode
    fi

# doc
elif [ $1 = 'doc' ]; then
    if [ $# -eq 1 ]; then checkdoc; gendoc
    elif [ $2 = 'check' ]; then checkdoc
    elif [ $2 = 'gen' ]; then gendoc
    else helpdoc
    fi

# loader
elif [ $1 = 'loader' ]; then
    if [ $# -eq 1 ]; then genclassmap
    elif [ $2 = 'classmap' ]; then genclassmap
    else helpdoc
    fi

# all
elif [ $1 = 'all' ]; then runall;

# help
else help;

fi
