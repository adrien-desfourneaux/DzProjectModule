<?php

/**
 * Fichier de source pour le ProjectService
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Service/Project.php
 */

namespace DzProjectModule\Service;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator;
use DzProjectModule\Mapper\ProjectInterface as ProjectMapperInterface;
use DzProjectModule\Options\ProjectServiceOptionsInterface;
use Traversable;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

use Zend\Stdlib\Exception\BadMethodCallException;

/**
 * Service pour les projets.
 *
 * @category Source
 * @package  DzProjectModule\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Service/Project.php
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
     * Hydrateur pour l'entité project.
     *
     * @var Hydrator\HydratorInterface
     */
    protected $projectHydrator;

    /**
     * Formulaire d'ajout de projet
     *
     * @var Form
     */
    protected $addForm;

    /**
     * Options pour le ProjectService
     *
     * @var ProjectServiceOptionsInterface
     */
    protected $options;

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
     * Redirige les méthodes de recherche
     * vers le mapper et le repository
     * Ajoute l'extraction des résultats
     *
     * @param string $method    Nom de la méthode appellée
     * @param array  $arguments Arguments passés à la méthode
     *
     * @return array
     */
    public function __call($method, $arguments)
    {
        $hydrator = $this->getProjectHydrator();

        // Match toutes les méthodes qui commencent par "find"
        // Puis dans le ProjectRepository
        if (strpos($method, 'find') == 0) {

            // Recherche d'abord dans le ProjectMapper
            // Puis dans le Repository
            $projectMapper = $this->getProjectMapper();
            $projectRepository = $projectMapper->getRepository();

            if (method_exists($projectMapper, $method)) {
                $object = &$projectMapper;
                $handler = array($object, $method);
                $return = call_user_func_array($handler, $arguments);
            } elseif (method_exists($projectRepository, $method)) {
                $object = &$projectRepository;
                $handler = array($object, $method);
                $return = call_user_func_array($handler, $arguments);
            } else {
                throw new BadMethodCallException(print_r($return, true) . "La méthode " . $method . " n'existe pas ni dans le ProjectMapper, ni dans le ProjectRepository.");
            }
        }

        // Les méthodes "find" renvoient null
        // si elle ne trouvent pas une entité
        // On renvoie false pour dire qu'il y
        // eu un problème
        if (!$return) {
            return false;
        }

        // C'est peut-être un tableau
        if (is_array($return)) {
            for ($i=0; $i<count($return); $i++) {
                $return[$i] = $hydrator->extract($return[$i]);
            }
        } else {
            $return = $hydrator->extract($return);
        }

        return $return;
    }

    /**
     * Ajoute un projet depuis les données du formulaire
     *
     * @param array $data Données du formulaire
     *
     * @return \DzProjectModule\Entity\ProjectInterface
     * @throws Exception\InvalidArgumentException
     */
    public function add(array $data)
    {
        // On obtient le nom de la classe entité
        // depuis pour que la personne qui utiliserait
        // le module puisse utiliser sa propre entité Project
        $class = $this->getOptions()->getProjectEntityClass();
        $project  = new $class;

        // On va tenter de faire correspondre le formulaire
        // remplit par l'utilisateur et les validators

        $form  = $this->getAddForm();
        $form->setHydrator($this->getProjectHydrator());
        $form->bind($project);
        $form->setData($data);

        // On retourne false si le formulaire remplit
        // est invalide
        if (!$form->isValid()) {
            return false;
        }

        /* @var $project \DzProjectModule\Entity\ProjectInterface */

        // On lance l'événement add pour que la personne qui utiliserait
        // le module puisse valider ses propres champs en implémentant le
        // Design Pattern Observateur
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('project' => $project, 'form' => $form));
        $this->getProjectMapper()->insert($project);

        $project = $form->getData();

        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('project' => $project, 'form' => $form));

        return $project;
    }

    /**
     * Supprime un projet
     *
     * @param integer $projectId Identifiant du projet à supprimer
     *
     * @return boolean
     */
    public function delete($projectId)
    {
        // Le service récupère le projet
        // auprès du mapper. Il faut vérifier
        // si le projet existe (s'il n'est pas null)
        $project = $this->getProjectMapper()->findById($projectId);

        // Si le projet n'a pas été trouvé
        // on renvoie false
        if (!$project) {
            return false;
        }

        // Suppression du projet
        $this->getProjectMapper()->delete($project);
        return true;
    }

    /**
     * Trouve un projet selon son identifiant
     * Renvoi un projet extrait via l'hydrateur de projet.
     *
     * @param integer $id      Identifiant du projet à trouver
     * @param bool    $extract Définit s'il faut extraire ou non via l'hydrateur
     *
     * @return mixed Données projet dans un array, ou Entité Projet
     */
    /*public function findById($id, $extract = true)
    {
        $project = $this->getProjectMapper()->getRepository()->findOneByProjectId($id);
        $hydrator = $this->getProjectHydrator();

        if ($extract) {
            $project = $hydrator->extract($project);
        }

        return $project;
    }*/

    /**
     * Trouve les projets selon leur type
     * Renvoi une collections de projets extraits
     * via l'hydrateur de projet.
     *
     * @param string $type    Type du projet à trouver
     * @param bool   $extract Définit s'il faut extraire ou non via l'hydrateur
     *
     * @return array Collection de projets
     */
    /*public function findByType($type, $extract = true)
    {
        $projects = $this->getProjectMapper()->findByType($type);
        $hydrator = $this->getProjectHydrator();

        if ($extract) {
            for ($i=0; $i<count($projects); $i++) {
                $projects[$i] = $hydrator->extract($projects[$i]);
            }
        }

        return $projects;
    }*/


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
     * Obtient l'Hydrateur de projet
     *
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getProjectHydrator()
    {
        if (!$this->projectHydrator instanceof Hydrator\HydratorInterface) {
            $this->setProjectHydrator($this->getServiceManager()->get('dzproject_project_hydrator'));
        }

        return $this->projectHydrator;
    }

    /**
     * Définit l'Hydrateur de projet
     *
     * @param Hydrator\HydratorInterface $projectHydrator Nouvel hydrateur
     *
     * @return Project
     */
    public function setProjectHydrator(Hydrator\HydratorInterface $projectHydrator)
    {
        $this->projectHydrator = $projectHydrator;

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
}
