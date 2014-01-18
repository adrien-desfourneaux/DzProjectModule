<?php

/**
 * DzProject module source
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/Module.php
 */

namespace DzProject;

/**
 * Classe module de DzProject.
 *
 * @category Source
 * @package  DzProject
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/Module.php
 */
class Module
{
    /**
     * Obtient le fichier de
     * configuration du module.
     * 
     * @return string
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Obtient la configuration de l'autoloader
     * pour les classes du module DzProject.
     *
     * @return array() Configuration de l'autoloader.
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
