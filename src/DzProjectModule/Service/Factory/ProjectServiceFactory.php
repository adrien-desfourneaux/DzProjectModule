<?php

/**
 * Fichier source pour le ProjectServiceFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Service\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Service\Factory;

use DzProjectModule\Service\ProjectService;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe ProjectServiceFactory.
 *
 * Classe usine pour le service de gestion des projets.
 *
 * @category Source
 * @package  DzProjectModule\Service\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectServiceFactory implements FactoryInterface
{
	/**
     * Cré et retourne le service de gestion des projets.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return Add
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new ProjectService;

        $locator   = $serviceLocator->getServiceLocator();
        $hydrators = $locator->get('HydratorManager');
        $forms     = $locator->get('FormElementManager');
        $options   = $locator->get('DzProjectModule\ModuleOptions');

        $entityClass = $options->getProjectEntityClass();
        $mapper      = $locator->get('DzProjectModule\ProjectMapper');
        $hydrator    = $hydrators->get('DzProjectModule\ProjectHydrator');
        $addForm     = $forms->get('DzProjectModule\AddForm');

        $service->setOptions($options);
        $service->setEntityClass($entityClass);
        $service->setMapper($mapper);
        $service->setHydrator($hydrator);

        $service->setAddForm($addForm);

        return $service;
    }
}