<?php

/**
 * ProjectService specification
 * @author     Adrien Desfourneaux
 * @package    DzProject\Service
 * @category   Spec
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

use DzProject\Model\ProjectManager;
use DzProject\Model\ProjectRepository;

/**
 * Service pour les projets.
 *
 * @see ServiceLocatorInterface
 */
class ProjectService implements
    ServiceLocatorAwareInterface
{
    // ServiceLocator {{{
    /**
     * Instance de Service Locator.
     * @var ServiceLocatorInterface
     */
    protected $sl;

    /**
     * Définit le Service Locator.
     *
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
        if(!$this->manager) {
            $this->manager = new ProjectManager();
            $this->manager->setEntityManager(
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
        if(!$this->repository) {
            $this->repository = new ProjectRepository();
            $this->repository->setEntityManager(
                $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')
            );
        }
        return $this->repository;
    }
    // }}}
}
