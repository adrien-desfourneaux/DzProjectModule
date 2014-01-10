<?php

/**
 * DzProject module source
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject
 * @category   Source
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject;

/**
 * Classe module de DzProject.
 *
 */
class Module
{
    /**
     * Obtient le fichier de
     * configuration du module.
     * 
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
