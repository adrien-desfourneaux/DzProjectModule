<?php

/**
 * Fichier source pour le SessionContainerFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container as SessionContainer;

/**
 * Classe SessionContainerFactory.
 *
 * Classe usine pour le conteneur de session du module DzProject.
 *
 * @category Source
 * @package  DzProjectModule\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class SessionContainerFactory implements FactoryInterface
{
	/**
     * Cré et retourne le conteneur de session du module DzProject.
     *
     * C'est dans ce fichier que l'on définit le nom du conteneur de session
     * pour le module DzProject.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return Add
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $container = new SessionContainer('dzproject');
        return $container;
    }
}