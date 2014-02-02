<?php

/**
 * Fichier de source du ProjectController
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Controller/ProjectController.php
 */

namespace DzProject\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DzProject\Service\Project as ProjectService;
use Zend\Stdlib\Exception;

/**
 * Classe contrôleur de projet.
 *
 * @category Source
 * @package  DzProject\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Controller/ProjectController.php
 * @see      AbstractActionController Contrôleur d'actions abstrait.
 */
class ProjectController extends AbstractActionController
{
    const ROUTE_SHOWMODULE = 'dzproject';
    const ROUTE_ADD        = 'dzproject/add';
    const ROUTE_SHOWALL    = 'dzproject/showall';

    const CONTROLLER_NAME  = 'dzproject';
    
    /**
     * Service pour les projets
     *
     * @var ProjectService
     */
    protected $projectService;

    /**
     * Formulaire d'ajout de projet
     * 
     * @var Form
     */
    protected $addForm;

    /**
     * Action par défaut du ProjectController
     * Information du module
     * ROUTE: /project
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Envoie le formulaire d'ajout de projet
     * Traite en retour les données du formulaire
     * ROUTE: /project/add
     *
     * @return ViewModel
     */
    public function addAction()
    {
        return new ViewModel();
    }

    /**
     * Traite les données du formulaire de suppression de projet
     * ROUTE: /project/delete/:id
     * GET: id Identifiant du projet à supprimer
     *
     * @return ViewModel
     */
    public function deleteAction()
    {
        return new ViewModel();
    }

    /**
     * Fiche projet
     * GET: id Identifiant du projet
     *
     * @return ViewModel
     */
    public function showAction()
    {
        return new ViewModel();
    }

    /**
     * Affiche un ensemble de projets
     * ROUTE: /project/show-all/:type
     * GET: type Type des projets à afficher
     *           all    Tous les projets
     *           active Seulement les projets actifs
     *
     * @return ViewModel
     */
    public function showallAction()
    {
        $type = $this->params()
            ->fromRoute('type');

        $projects = $this->getProjectService()
            ->getProjectMapper()
            ->findByType($type);

        return new ViewModel(
            array(
                'projects' => $projects
            )
        );
    }

    /**
     * Obtient le service pour le projet
     *
     * @return ProjectService
     */
    public function getProjectService()
    {
        if (!$this->projectService) {
            $this->projectService = $this->getServiceLocator()->get('dzproject_project_service');
        }
        return $this->projectService;
    }

    /**
     * Définit le service pour le projet
     * 
     * @param ProjectService $projectService Service pour le projet
     *
     * @return ProjectController
     */
    public function setProjectService(ProjectService $projectService)
    {
        $this->projectService = $projectService;
        return $this;
    }
}
