<?php

/**
 * ProjectService source
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Service/ProjectService.php
 */

namespace DzProject\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

use DzProject\Model\ProjectManager;
use DzProject\Model\ProjectRepository;

/**
 * Service pour les projets.
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Service/ProjectService.php
 * @see      ServiceLocatorInterface
 */
class ProjectService implements
    ServiceLocatorAwareInterface
{
    // ServiceLocator {{{
    /**
     * Instance de Service Locator.
     *
     * @var ServiceLocatorInterface ServiceLocator used by the ProjectService
     */
    protected $sl;

    /**
     * Définit le Service Locator.
     *
     * @param ServiceLocatorInterface $serviceLocator The ServiceLocator to inject
     *
     * @return null
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sl = $serviceLocator;
    }

    /**
     * Obtient le Service Locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->sl;
    }
    // }}}

    // ProjectManager {{{
    /**
     * Manager pour les projets.
     * @var ProjectManager
     */
    protected $manager;

    /**
     * Obtient le ProjectManager.
     *
     * @return ProjectManager
     */
    public function getManager()
    {
        if (!$this->manager) {
            $this->manager = new ProjectManager(
                $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')
            );
        }
        return $this->manager;
    }
    // }}}

    // ProjectRepository {{{
    /**
     * Repository pour les projets.
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * Obtient le ProjectRepository.
     *
     * @return ProjectRepository
     */
    public function getRepository()
    {
        if (!$this->repository) {
            $this->repository = new ProjectRepository(
                $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')
            );
        }
        return $this->repository;
    }
    // }}}
    
    /**
     * Construct a new instance of ProjectService
     *
     * @param ProjectManager    $projectManager    The ProjectManager to inject
     * @param ProjectRepository $projectRepository The ProjectRepository to inject
     */
    public function __construct($projectManager, $projectRepository)
    {
        $this->_manager    = $projectManager;
        $this->_repository = $projectRepository;
    }
}
