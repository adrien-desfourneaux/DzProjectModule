<?php

/**
 * Fichier source pour le ProjectControllerFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Controller\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Controller\Factory;

use DzProjectModule\Controller\ProjectController;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe ProjectControllerFactory.
 *
 * Classe usine pour le controller de projets.
 *
 * @category Source
 * @package  DzProjectModule\Controller\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectControllerFactory implements FactoryInterface
{
	/**
     * Cré et retourne le controller de projets.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new ProjectController;

        $locator      = $serviceLocator->getServiceLocator();
        $options      = $locator->get('DzProjectModule\ModuleOptions');

        $controller->setOptions($options); // Pour avoir les options du contrôleur.

        return $controller;
    }
}