<?php

/**
 * Lance l'application de test du module DzProjectModule.
 * Seuls le module DzProjectModule et ses dépendances seront chargées.
 * Cela permet le test du module DzProjectModule seul, séparé
 * du reste de l'application.
 *
 * Copier ce fichier dans le répertoire public de votre application
 *
 * Utilisation :
 * http://mydomain/dzproject.test.php/project[/:action]
 *
 * PHP Version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/dzproject.test.php
 */

/**
 * Définit l'environnement d'exécution pour le module.
 */
define('DZPROJECT_ENV', 'test');

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
Zend\Mvc\Application::init(require 'module/DzProjectModule/config/application.config.php')->run();
