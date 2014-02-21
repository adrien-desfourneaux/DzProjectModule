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
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventmanagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use Zend\Uri\Http as HttpUri;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use DzProject\Service\Project as ProjectService;
use Zend\Session\Container;

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
class ProjectController
extends AbstractActionController
{
    const ROUTE_SHOWMODULE = 'dzproject';
    const ROUTE_ADD        = 'dzproject/add';
    const ROUTE_DELETE     = 'dzproject/delete';
    const ROUTE_LIST       = 'dzproject/list';
    const ROUTE_ERROR      = 'dzproject/error';

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
     * Champs de listing des projets
     *
     * Tableau des champs du tableau à afficher
     * pour le listing projets. Les champs de type
     * "Action" (comme Delete par exemple) ne sont
     * pas pris en compte.
     *
     * Format:
     * $fields = array(
     *      array(
     *          'heading' => 'Titre du champ (<th>)',
     *          'href' => array(
     *              '1' => "Lien <a href=...> pour le projet d'identifiant 1",
     *              '2' => "Lien <a href=...> pour le projet d'identifiant 2",
     *              ...
     *          ),
     *          'values'  => array(
     *              '1' => "Valeur pour le projet d'identifiant 1",
     *              '2' => "Valeur pour le projet d'identifiant 2",
     *              ...
     *          ),
     *          'class' => array(
     *              '1' => "Classe (class) pour la valeur du projet d'identifiant 1",
     *              '2' => "Classe (class) pour la valuer du projet d'identifiant 2",
     *              ...
     *          )
     *      ),
     *      ...
     * );
     *
     * L'ordre des heading est l'odre dans lequel
     * ils seront affichés de gauche à droite.
     * Tous les champs sont optionnels
     *
     * @var array
     */
    protected $listFields = array();

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
    protected $failedAddMessage = "Echec de l'ajout. Veuillez réessayer.";

    /**
     * Message d'échec de la suppression de projet
     *
     * @var string
     */
    protected $failedDeleteMessage = "Echec de la suppression. Veuillez réessayer.";

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


    public function errorAction()
    {
        $errorMessage = $this->Params()->fromPost('errorMessage', "Aucun message d'erreur à afficher");

        return new ViewModel(
            array(
                'errorMessage' => $errorMessage,
            )
        );
    }

    /**
     * Envoie le formulaire d'ajout de projet
     * Traite en retour les données du formulaire
     * ROUTE: /project/add
     * GET: redirectSuccess -> url de redirection en cas de succès de l'ajout
     *      routeFailure -> array urlencodé serialisé contenant le nom et les paramètres
     *                      de la route en cas d'échec de l'ajout
     *
     * @return ViewModel
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $service = $this->getProjectService();

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirectSuccess')) {
            $redirectSuccess = $request->getQuery()->get('redirectSuccess');
        } else {
            $redirectSuccess = false;
        }

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirectFailure')) {
            $redirectFailure = $request->getQuery()->get('redirectFailure');
        } else {
            $redirectFailure = false;
        }

        if ($request->getQuery()->get('hasTitle') !== null) {
            $hasTitle = $request->getQuery()->get('hasTitle');
        } else {
            // Toujours afficher le titre dans la vue retournée par un controller
            $hasTitle = true;
        }

        if ($request->getQuery()->get('hasSubmit') !== null) {
            $hasSubmit = $request->getQuery()->get('hasSubmit');
        } else {
            // Toujours afficher le bouton de submit dans la vue retournée par un controller
            $hasSubmit = true;
        }

        $redirectUrl = $this->url()->fromRoute(static::ROUTE_ADD);

        if ($redirectSuccess && !$redirectFailure) {
            $redirectUrl = $redirectUrl . '?redirectSuccess=' . $redirectSuccess;
        } elseif ($redirectFailure && !$redirectSuccess) {
            $redirectUrl = $redirectUrl . '?redirectFailure=' . $redirectFailure;
        } elseif ($redirectSuccess && $redirectFailure) {
            $redirectUrl = $redirectUrl . '?redirectSuccess=' . $redirectSuccess . '&redirectFailure=' . $redirectFailure;
        }
        
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            // On va afficher le formulaire.
            // On récupère le formulaire, ses données et ses erreurs
            $form = $this->getAddForm();
            $form->retrieveData();
            $form->retrieveMessages();

            return array(
                'addForm' => $form,
                'hasTitle' => $hasTitle,
                'hasSubmit' => $hasSubmit,
                'redirectSuccess' => $redirectSuccess,
                'redirectFailure' => $redirectFailure
            );
        }

        $post = $prg;

        $project = $service->add($post);

        $redirectSuccess = isset($prg['redirectSuccess']) ? $prg['redirectSuccess'] : null;
        $redirectFailure = isset($prg['redirectFailure']) ? $prg['redirectFailure'] : null;

        if (!$project) {
            // On va faire une redirection "header: location"
            // On stocke les données et les messages d'erreur du formulaire en session
            // pour pouvoir les récupérer après la redirection
            $form = $this->getAddForm();
            $form->saveData();
            $form->saveMessages();

            if ($redirectFailure) {
           
                return $this->redirect()->toUrl($redirectFailure);

            } else {
                return array(
                    'addForm' => $form,
                    'hasTitle' => $hasTitle,
                    'hasSubmit' => $hasSubmit,
                    'redirectSuccess' => $redirectSuccess,
                    'redirectFailure' => $redirectFailure
                );
            }
        }

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirectSuccess) {
            return $this->redirect()->toUrl($redirectSuccess);
        } else {
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LIST));
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
        $request = $this->getRequest();
        $service = $this->getProjectService();

        $id = $this->params()->fromRoute('id');
    
        try {
            $project = $this->getProjectService()->findById($id);
        } catch (\Exception $e) {
            // envoyer le message d'erreur via POST
            $request->getPost()->set('errorMessage', $e->getMessage());
            
            // dispatcher le controller "dzproject" avec l'action "error"
            $viewModel = $this->forward()->dispatch('dzproject', array('action' => 'error'));
            
            // render le ViewModel
            $viewRenderer = $this->getServiceLocator()->get('ViewRenderer');
            $html = $viewRenderer->render($viewModel);

            return $html;
        }

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }

        $redirectUrl = $this->url()->fromRoute(static::ROUTE_DELETE, array('id' => $id))
            . ($redirect ? '?redirect=' . $redirect : '');

        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'project' => $project,
                'redirect' => $redirect,
            );
        }

        $post = $prg;

        try {
            $service->delete($id);
        } catch (\Exception $e) {
            // envoyer le message d'erreur via POST
            $request->getPost()->set('errorMessage', $this->failedDeleteMessage);
            $response = $this->forward()->dispatch('dzproject', array('action' => 'error'));
            return $response;
        }
        

        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        } else {
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LIST));
        }
    }

    /**
     * Affiche un listing des projets
     * ROUTE: /project/list/:type
     * GET: type Type des projets à afficher
     *           all    Tous les projets
     *           active Seulement les projets actifs
     *
     * @return ViewModel
     */
    public function listAction()
    {
        $type = $this->params()
            ->fromRoute('type');

        // On récupére les erreurs éventuelles
        // du AddFrom depuis la session
        $addForm = $this->getAddForm();
        $addForm->retrieveMessages();

        $projects = $this->getProjectService()->findByType($type);
        $hasDeleteAction = $this->getOptions()->getProjectListHasDeleteAction();
        $hasAddAction = $this->getOptions()->getProjectListHasAddAction();

        $fields = array();
        $fields[0] = array('heading' => 'Désignation');
        $fields[1] = array('heading' => 'Période');

        foreach ($projects as $p) {
            $fields[0]['values'][$p['project_id']] = $p['display_name'];
            $fields[1]['values'][$p['project_id']] = $p['begin_date'] . ' - ' . $p['end_date'];
        }

        $this->setListFields($fields);
        $this->getEventManager()->trigger('initListFields', $this, array('projects' => $projects));
        $fields = $this->getListFields();

        return new ViewModel(
            array(
                'projects' => $projects,
                'fields' => $fields,
                'hasDeleteAction' => $hasDeleteAction,
                'hasAddAction' => $hasAddAction,
                'addForm' => $addForm,
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
     * Obtient les champs du listing des projets
     *
     * @return array
     */
    public function getListFields()
    {
        return $this->listFields;
    }

    /**
     * Définit les champs du listing des projets
     *
     * @param array $listFields Nouvel array contenant les champs
     *
     * @return void
     */
    public function setListFields($listFields)
    {
        $this->listFields = $listFields;
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
