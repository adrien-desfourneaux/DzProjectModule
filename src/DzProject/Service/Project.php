<?php

/**
 * Fichier de source pour le ProjectService
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

use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator;
use DzProject\Mapper\ProjectInterface as ProjectMapperInterface;
use DzProject\Options\ProjectServiceOptionsInterface;

/**
 * Service pour les projets.
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Service/ProjectService.php
 * @see      ServiceManagerAwareInterface
 */
class Project implements ServiceManagerAwareInterface
{
    /**
     * Mapper pour l'entité project.
     *
     * @var ProjectMapperInterface
     */
    protected $projectMapper;

    /**
     * Instance de ServiceManager
     * 
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Options pour le ProjectService
     * 
     * @var ProjectServiceOptionsInterface
     */
    protected $options;

    /**
     * Hydrateur pour l'entité projet
     *
     * @var Hydrator\ClassMethods
     */
    protected $formHydrator;

    /**
     * Obtient l'instance du ProjectMapper
     *
     * @return ProjectMapperInterface
     */
    public function getProjectMapper()
    {
        if (null === $this->projectMapper) {
            $this->projectMapper = $this->getServiceManager()->get('dzproject_project_mapper');
        }
        return $this->projectMapper;
    }

    /**
     * Définit l'instance du ProjectMapper
     *
     * @param ProjectMapperInterface $projectMapper Instance de ProjectMapper
     *
     * @return Project
     */
    public function setProjectMapper(ProjectMapperInterface $projectMapper)
    {
        $this->projectMapper = $projectMapper;
        return $this;
    }

    /**
     * Obtient l'instance du ServiceManager
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Définit l'instance du ServiceManager
     *
     * @param ServiceManager $serviceManager Instance de ServiceManager
     *
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
