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
    const ROUTE_DELETE     = 'dzproject/delete';
    const ROUTE_SHOWALL    = 'dzproject/showall';
    const ROUTE_SHOWACTIVE = 'dzproject/showall/active';

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
     * Formulaire de suppression de projet
     *
     * @var Form
     */
    protected $deleteForm;

    /**
     * Action par défaut du ProjectController
     * Affiche les informations du module.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Traite les données du formulaire d'ajout de projet
     *
     * @return null
     */
    public function addAction()
    {
    }

    /**
     * Traite les données du formulaire de suppression de projet
     *
     * @return null
     */
    public function deleteAction()
    {
    }

    /**
     * Affiche un projet particulier
     *
     * @return null
     */
    public function showAction()
    {
    }

    /**
     * Affiche un ensemble de projets
     *
     * @return ViewModel
     */
    public function showallAction()
    {
        $type = $this->params()
            ->fromRoute('type');

        $projects = array();

        if ($type == 'all') {
            $projects = $this->getProjectService()
                ->getProjectMapper()
                ->findAll();
        } else if ($type == 'active') {
            $projects = $this->getProjectService()
                ->getProjectMapper()
                ->findActive();
        }

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
