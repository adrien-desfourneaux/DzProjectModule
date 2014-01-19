<?php

/**
 * ProjectServiceFactory source
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Service/ProjectServiceFactory.php
 */

namespace DzProject\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use DzProject\Service\ProjectService;
use DzProject\Model\ProjectManager;
use DzProject\Model\ProjectRepository;

/**
 * Factory qui construit le Service pour les projets.
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Service/ProjectService.php
 * @see      ServiceLocatorInterface
 */
class ProjectServiceFactory implements
    FactoryInterface
{
    /**
     * Create service
     * 
     * @param ServiceLocatorInterface $serviceLocator Instance of ServiceLocatorInterface
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ProjectService(
            new ProjectManager($serviceLocator->get('doctrine.entitymanager.orm_default')),
            new ProjectRepository($serviceLocator->get('doctrine.entitymanager.orm_default'))
        );
    }  
}
