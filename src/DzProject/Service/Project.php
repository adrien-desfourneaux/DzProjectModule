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
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Service/Project.php
 */

namespace DzProject\Service;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator;
use DzProject\Mapper\ProjectInterface as ProjectMapperInterface;
use DzProject\Options\ProjectServiceOptionsInterface;
use Traversable;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

/**
 * Service pour les projets.
 *
 * @category Source
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Service/Project.php
 * @see      ServiceManagerAwareInterface
 */
class Project implements
    ServiceManagerAwareInterface,
    EventManagerAwareInterface
{
    /**
     * Mapper pour l'entité project.
     *
     * @var ProjectMapperInterface
     */
    protected $projectMapper;

    /**
     * Formulaire d'ajout de projet
     * 
     * @var Form
     */
    protected $addForm;

    /**
     * Instance de ServiceManager
     * 
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Instance implémentant EventManagerInterface
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

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
     * Ajoute un projet depuis les données du formulaire
     *
     * @param array $data Données du formulaire
     *
     * @return \DzProject\Entity\ProjectInterface
     * @throws Exception\InvalidArgumentException
     */
    public function add(array $data)
    {
        $class = $this->getOptions()->getProjectEntityClass();
        $project  = new $class;
        $form  = $this->getAddForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($project);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }

        /* @var $project \DzProject\Entity\ProjectInterface */
        
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('project' => $project, 'form' => $form));
        $this->getProjectMapper()->insert($project);

        $project = $form->getData();
        
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('project' => $project, 'form' => $form));
        return $project;
    }

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
     * Obtient le formulaire d'ajout de projet
     *
     * @return Form
     */
    public function getAddForm()
    {
        if (null === $this->addForm) {
            $this->addForm = $this->getServiceManager()->get('dzproject_add_form');
        }
        return $this->addForm;
    }

    /**
     * Définit le formulaire d'ajout de projet
     *
     * @param Form $addForm Nouveau formulaire d'ajout de projet
     *
     * @return Project
     */
    public function setAddForm(Form $addForm)
    {
        $this->addForm = $addForm;
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

    /**
     * Définit l'instance d'EventManager
     *
     * @param EventManagerInterface $eventManager Nouvel EventManager
     *
     * @return mixed
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $identifiers = array(__CLASS__, get_called_class());
        if (isset($this->eventIdentifier)) {
            if ((is_string($this->eventIdentifier))
                || (is_array($this->eventIdentifier))
                || ($this->eventIdentifier instanceof Traversable)
            ) {
                $identifiers = array_unique(array_merge($identifiers, (array) $this->eventIdentifier));
            } elseif (is_object($this->eventIdentifier)) {
                $identifiers[] = $this->eventIdentifier;
            }
            // silently ignore invalid eventIdentifier types
        }
        $eventManager->setIdentifiers($identifiers);
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Obtient l'EventManager
     *
     * Chargement paresseux de l'instance EventManager
     * si aucune n'est enregistrée.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->eventManager instanceof EventManagerInterface) {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }

    /**
     * Obtient les options du service des projets
     *
     * @return ProjectServiceOptionsInterface
     */
    public function getOptions()
    {
        if (!$this->options instanceof ProjectServiceOptionsInterface) {
            $this->setOptions($this->getServiceManager()->get('dzproject_module_options'));
        }
        return $this->options;
    }

    /**
     * Définit les options du service des projets
     *
     * @param ProjectServiceOptionsInterface $options Options du service
     *
     * @return void
     */
    public function setOptions(ProjectServiceOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * Obtient l'Hydrateur de formulaire
     *
     * @return \Zend\Stdlib\Hydrator\ClassMethods
     */
    public function getFormHydrator()
    {
        if (!$this->formHydrator instanceof Hydrator\ClassMethods) {
            $this->setFormHydrator($this->getServiceManager()->get('dzproject_add_form_hydrator'));
        }

        return $this->formHydrator;
    }

    /**
     * Définit l'Hydrateur de formulaire à utiliser
     *
     * @param Hydrator\ClassMethods $formHydrator Nouvel hydrateur
     *
     * @return Project
     */
    public function setFormHydrator(Hydrator\ClassMethods $formHydrator)
    {
        $this->formHydrator = $formHydrator;
        return $this;
    }
}
