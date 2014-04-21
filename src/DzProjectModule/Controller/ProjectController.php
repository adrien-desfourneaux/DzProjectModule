<?php

/**
 * Fichier de source du ProjectController.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Controller;

use DzBaseModule\Controller\AbstractActionController;
use DzBaseModule\Uri\QueryParameters;

use DzViewModule\View\Model\ViewModel;

use Zend\Form\FormInterface;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ModelInterface;

/**
 * Classe contrôleur de projet.
 *
 * @category Source
 * @package  DzProjectModule\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://github.com/dieze/DzProjectModule
 */
class ProjectController extends AbstractActionController
{
    const ROUTE_SHOWMODULE = 'dzproject';
    const ROUTE_ADD        = 'dzproject/add';
    const ROUTE_DELETE     = 'dzproject/delete';
    const ROUTE_LIST       = 'dzproject/list';

    const CONTROLLER_NAME  = 'dzproject';

    /**
     * Action par défaut du ProjectController
     * Information du module
     * ROUTE: /project
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $viewModel = $this->getViewModel('index');

        return $viewModel;
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
        $options     = $this->getOptions();
        $service     = $this->getService('project');
        $viewModel   = $this->getViewModel('add');
        $form        = $this->getForm('add');
        $useRedirect = $options->getUseRedirectParameterIfPresent();

        // Redirige en prenant en compte les paramètres de requête.

        $baseUrl = $this->url()->fromRoute(static::ROUTE_ADD);

        $queryParams = new QueryParameters();
        $queryParams->setQuery($this->getRequest()->getQuery());

        $queryParams->fetch('hasTitle', true);
        $queryParams->fetch('hasSubmit', true);
        $queryParams->fetch('redirectSuccess', false);
        $queryParams->fetch('redirectFailure', false);

        $queryString = $queryParams->encode();

        $redirect = $baseUrl . '?' . $queryString;

        $prg = $this->prg($redirect, true);

        if ($prg instanceof Response) {
            // Données POST présentes.
            // PRG les stocke en session
            // et fait une redirection 301

            $form->persist();

            return $prg;
        } elseif ($prg === false) {
            // Aucune données POST.
            // Affichage de la page
            // pour la première fois

            $form->retrieve();

            $viewModel->setVariables($queryParams);
            return $viewModel;
        }

        // Données POST contenues dans $prg
        $post = $prg;

        $redirectSuccess = isset($prg['redirectSuccess']) ? $prg['redirectSuccess'] : null;
        $redirectFailure = isset($prg['redirectFailure']) ? $prg['redirectFailure'] : null;

        // Envoi des données POST au service des projets
        // qui s'occupe de l'ajout
        $project = $service->add($post);

        // Si l'ajout a échoué, le service des projets renvoie false
        // Il y a redirection selon si l'ajout a échoué ou a réussi

        if (!$project) {

            $form->persist();

            if ($useRedirect && $redirectFailure) {
                // Redirection selon l'option redirectFailure
                return $this->redirect()->toUrl($redirectFailure);
            } else {
                $viewModel->setVariables($queryParams->toArray());
                $viewModel->setVariable('redirectSuccess', $redirectSuccess);
                $viewModel->setVariable('redirectFailure', $redirectFailure);

                return $viewModel;
            }
        }

        // L'ajout a réussi
        // Redirection selon le paramètre redirectSuccess
        // sinon afficher la liste des projets

        if ($useRedirect && $redirectSuccess) {
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
        $options     = $this->getOptions();
        $service     = $this->getService('project');
        $viewModel   = $this->getViewModel('delete');
        $useRedirect = $options->getUseRedirectParameterIfPresent();

        // Redirige en prenant en compte les paramètres de requête.

        // Identifiant du projet à supprimer
        // que l'on récupère depuis la route
        $id = (int)$this->params()->fromRoute('id');

        $baseUrl = $this->url()->fromRoute(static::ROUTE_DELETE, array('id' => $id));

        $queryParams = new QueryParameters();
        $queryParams->setQuery($this->getRequest()->getQuery());

        $queryParams->fetch('hasTitle', true);
        $queryParams->fetch('hasSubmit', true);
        $queryParams->fetch('redirect', false);

        $queryString = $queryParams->encode();

        $redirect = $baseUrl . '?' . $queryString;

        $prg = $this->prg($redirect, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {

            // Affichage du formulaire de suppression de projet.
            $viewModel->setVariables($queryParams->toArray());
            $viewModel->setVariable('id', $id);

            return $viewModel;
        }

        $post = $prg;

        // On passe l'identifiant au service des projets
        // qui va s'occuper de supprimer le projet.

        $success = $service->delete($id);

        if (!$success) {
            $message = $this->message('project delete failed');
            return $this->messageModel($message);
        }

        // Redirection si succès de l'ajout
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

        // Redirige selon si l'on a fournit l'option redirect
        // Si non, on redirige vers la liste des projets
        if ($useRedirect && $redirect) {
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
        $options         = $this->getOptions();
        $service         = $this->getService('project');
        $viewModel       = $this->getViewModel('list');
        $useRedirect     = $options->getUseRedirectParameterIfPresent();
        $hasAddAction    = $options->getProjectListHasAddAction();
        $hasDeleteAction = $options->getProjectListHasDeleteAction();

        // Options de requête
        $hasTitle        = (bool)$this->params()->fromQuery('hasTitle', true);
        $hasAddAction    = (bool)$this->params()->fromQuery('hasAddAction', $hasAddAction);
        $hasDeleteAction = (bool)$this->params()->fromQuery('hasDeleteAction', $hasDeleteAction);

        // Option de route
        $type = $this->params()->fromRoute('type');

        $viewModel->setVariables(
            array(
                'hasTitle'        => $hasTitle,
                'hasDeleteAction' => $hasDeleteAction,
                'hasAddAction'    => $hasAddAction,
                'type'            => $type,
            )
        );

        return $viewModel;
    }

    /**
     * Obtient un service.
     *
     * @param string $name Nom du service à obtenir.
     *
     * @return 
     */
    public function getService($name)
    {
        switch ($name)
        {
            case 'project':
                return $this->service('DzProjectModule\ProjectService');
                break;
        }
    }

    /**
     * Obtient un ViewModel.
     *
     * @param string $page Page correspandant au ViewModel à obtenir.
     *
     * @return ModelInterface
     */
    public function getViewModel($page)
    {
        switch ($page)
        {
            case 'index':
                return new ViewModel();
                break;

            case 'add':
                return $this->viewmodel('DzProjectModule\AddViewModel');
                break;

            case 'delete':
                return $this->viewmodel('DzProjectModule\DeleteViewModel');
                break;

            case 'list':
                return $this->viewmodel('DzProjectModule\ListViewModel');
                break;
        }
    }

    /**
     * Obtient un formulaire.
     *
     * @param string $name Nom du formulaire à obtenir.
     *
     * @return FormInterface
     */
    public function getForm($name)
    {
        switch ($name)
        {
            case 'add':
                return $this->form('DzProjectModule\AddForm');
        }
    }
}
