DzProject
=========

Module de management de projet pour ZF2

Installation
==========
Bientôt...

Utilitaires
==================

Quelques utilitaires sous la forme de scripts shell peuvent être trouvés dans le répertoire script :

- **run_doc.sh** : Lancer la génération de documentation en utilisant [phpDocumentor](http://www.phpdoc.org/). La documentation générée se situe dans le répertoire **doc** du module.
- **run_metrics.sh** : Lance la génération des métriques en utilisant [PHP Depend](http://pdepend.org/) et [PHPLoc](https://github.com/sebastianbergmann/phploc). Les métriques générés se situent dans le répertoire **metrics** du module.
- **run_sniffers.sh** : Lance les sniffers (dont [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), [PHP Mess Detector](http://phpmd.org/), et quelques vérifications de la validité des blocks de documentation de code (DocBlocks).
- **run_tests.sh** : Lance les tests de spécifications avec [phpspec](http://www.phpspec.net/) et les tests d'acceptation avec [Codeception](http://codeception.com/). Quelques prérequis doivent être remplis avant de lancer les tests d'acceptation, voir **Prérequis pour les tests d'acceptation Codeception**
- **run_all.sh** : Lance tous les scripts ci-dessus.

Comme il s'agit de script sheel, il ne peuvent être exécutés que sur un système d'exploitation unix.

Prérequis pour les tests d'acceptation Codeception
=====================================
Les tests d'acceptation Codeception utilisent Selenium pour diriger un navigateur web et lancer les tests.
Il y a quelques prérequis pour pouvoir lancer les tests d'acceptation.

Créer un fichier **zf2\_app/public/dzproject.test.php** qui contient :

	<?php
	/**
	 * This makes our life easier when dealing with paths. Everything is relative
	 * to the application root now.
	 */
	chdir(dirname(__DIR__));

	// Decline static file requests back to the PHP built-in webserver
	if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    	return false;
	}

	// Setup autoloading
	require 'init_autoloader.php';

	// Run the application!
	Zend\Mvc\Application::init(require 'module/DzProject/config/application.config.php')->run();
	
La partie importante se situe sur la dernière ligne, là où on lance l'application en utilisant le fichier application.config.php du module.

Editer le fichier **DzProject/config/acceptance.suite.yml** :

	class_name: WebGuy
	modules:
    	enabled:
	        - Db
	        - WebDriver
	    config:
    	    WebDriver:
        	    url: 'http://0.0.0.0/dzproject.test.php'
	            browser: firefox
	            host: 0.0.0.0

**Dans "url", définir l'url à charger pour lancer l'application.**
**Dans "host", définir l'ip de la machine où est lancé le serveur Selenium2 (voir ci-dessous)**

Aller dans le répertoire du module et lancer le serveur Selenium2 :
	
	java -jar tests/selenium-server-standalone-2.39.0.jar

La navigateur web firefox doit être installé sur votre machine.

Vous pouvez maintenant lancer les tests d'acceptation.
Pour lancer un test d'acceptation (ShowModuleInformationCept par exemple), aller dans le répertoire du module et lancer la commande :

	../../vendor/bin/codecept run tests/acceptance/ShowModuleInformationsCept.php
	
Vous pouvez également lancer tous les tests d'acceptation avec la commande :

	../../vendor/bin/codecept run
	
Il est aussi possible d'utiliser le script shell qui va lancer tous les tests d'acceptation :

	script/run_tests.sh cept