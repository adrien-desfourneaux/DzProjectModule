<?php

/**
 * Lance l'application de développement du module DzProjectModule.
 *
 * Seuls le module DzProjectModule et ses dépendances seront chargées.
 * Cela permet le développement du module DzProjectModule seul, séparé
 * du reste de l'application.
 *
 * Copier ce fichier dans le répertoire public de votre application.
 *
 * Utilisation :
 * http://mydomain/dzproject.php/project/[:action]
 *
 * PHP Version 5
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

/**
 * Définit l'environnement d'exécution pour le module.
 */
define('DZPROJECT_ENV', 'development');

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
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
