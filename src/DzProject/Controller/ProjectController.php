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
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use DzProject\Service\Project as ProjectService;
use Zend\Stdlib\Exception;

use DzProject\Options\ProjectControllerOptionsInterface;

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
     * Options pour le ProjectController
     *
     * @var ProjectControllerOptionsInterface
     */
    protected $options;

    /**
     * Message d'échec d'ajout de projet
     * @var string
     */
    protected $failedAddMessage = "'Echec de l'ajout. Veuillez réessayer.";

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
        $request = $this->getRequest();
        $service = $this->getProjectService();
        $form    = $this->getAddForm();

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }

        $redirectUrl = $this->url()->fromRoute(static::ROUTE_ADD)
            . ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'addForm' => $form,
                'redirect' => $redirect,
            );
        }

        $post = $prg;

        $project = $service->add($post);

        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

        if (!$project) {
            return array(
                'addForm' => $form,
                'redirect' => $redirect,
            );
        }

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        } else {
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_SHOWALL));
        }
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

    /**
     * Obtient le formulaire d'Ajout de projet
     *
     * @return Form
     */
    public function getAddForm()
    {
        if (!$this->addForm) {
            $this->setAddForm($this->getServiceLocator()->get('dzproject_add_form'));
        }
        return $this->addForm;
    }

    /**
     * Définit le formulaire d'Ajout de projet
     *
     * @param Form $addForm Nouveau formulaire d'Ajout de projet
     *
     * @return void
     */
    public function setAddForm(Form $addForm)
    {
        $this->addForm = $addForm;
    }

    /**
     * Définit les options pour le ProjectController
     *
     * @param ProjectControllerOptionsInterface $options Nouvelles options
     *
     * @return ProjectController
     */
    public function setOptions(ProjectControllerOptionsInterface $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Obtient les options pour le ProjectController
     *
     * @return ProjectControllerOptionsInterface
     */
    public function getOptions()
    {
        if (!$this->options instanceof ProjectControllerOptionsInterface) {
            $this->setOptions($this->getServiceLocator()->get('dzproject_module_options'));
        }
        return $this->options;
    }
}
