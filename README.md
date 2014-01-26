DzProject
=========

Project management ZF2 module

Install
==========
Coming soon...

Shell script utilities
==================

Some shell script utilities can be found in the script folder :

- **run_doc.sh** : run documentation generation using [phpDocumentor](http://www.phpdoc.org/) . Documentation can be found in the **doc** folder of the module.
- **run_metrics.sh** : run metrics generation using [PHP Depend](http://pdepend.org/) and [PHPLoc](https://github.com/sebastianbergmann/phploc). Metrics can be found in the **metrics** folder of the module.
- **run_sniffers.sh** : run some sniffers (including [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), [PHP Mess Detector](http://phpmd.org/), and some docblocks checks).
- **run_tests.sh** : run specification tests with [phpspec](http://www.phpspec.net/) and acceptance tests with [Codeception](http://codeception.com/). There are some prerequisites for acceptance tests, see **Codeception acceptance tests prerequisites**
- **run_all.sh** : run all scripts above.

As they are shell scripts, They can only be run on a unix system.


Codeception acceptance test prerequisites
=====================================
Codeception acceptance tests use Selenium in order to drive web browser and run tests.
There are some prerequisites for the acceptance tests to run.

Create a file **zf2\_app/public/dzproject.php** that contains something like :

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
	Zend\Mvc\Application::init(require 'module/DzProject/tests/application.config.php')->run();
	
The important part is on the last line, when we start the application using the application.config.php of the module.

Edit the file **DzProject/tests/acceptance.suite.yml** :

	class_name: WebGuy
	modules:
    	enabled:
	        - Db
	        - WebDriver
	    config:
    	    WebDriver:
        	    url: 'http://0.0.0.0/dzproject.php'
	            browser: firefox
	            host: 0.0.0.0

**In url, set the url to load the application.**
**In host, set the host ip where it can find the Selenium2 WebDriver (see below)**

Go to the root folder of the module and start the Selenium2 WebDriver :
	
	java -jar tests/selenium-server-standalone-2.39.0.jar

You need to have firefox installed on your host machine.

Now you can run acceptance tests.
To start an acceptance test (ShowModuleInformationCept for example), go to the module root folder and run :

	../../vendor/bin/codecept run tests/acceptance/ShowModuleInformationsCept.php
	
You can also run all acceptance tests with

	../../vendor/bin/codecept run
	
Or use the shell script utility that will also run all specs :

	script/run_tests.sh