<?php

/**
 * Fichier de source du ProjectController
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Controller/ProjectController.php
 */

namespace DzProjectModule\Controller;

use Zend\Form\Form;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventmanagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use Zend\Uri\Http as HttpUri;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use DzProjectModule\Service\Project as ProjectService;
use Zend\Session\Container;

use DzProjectModule\Options\ProjectControllerOptionsInterface;

/**
 * Classe contrôleur de projet.
 *
 * @category Source
 * @package  DzProjectModule\Controller
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Controller/ProjectController.php
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
     * Message d'échec lorsqu'un projet demandé n'existe pas
     *
     * @var string
     */
    protected $oneNotFoundMessage = "Le projet demandé n'a pas été trouvé";

    /**
     * Message d'échec lorsque des projets demandés n'existent pas
     *
     * @var string
     */
    protected $manyNotFoundMessage = "Les projets demandés n'ont pas été trouvés";

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

    /**
     * Action en cas d'erreur
     *
     * @return ViewModel
     */
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
        // Préparation de la page

        $request = $this->getRequest();
        $service = $this->getProjectService();

        /*$form = $this->getAddForm();
        $form->retrieveData(false);
        $form->retrieveMessages(false);*/

        // Option de redirection si succès de l'ajout
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirectSuccess')) {
            $redirectSuccess = $request->getQuery()->get('redirectSuccess');
        } else {
            $redirectSuccess = false;
        }

        // Option de redirection si échec de l'ajout
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirectFailure')) {
            $redirectFailure = $request->getQuery()->get('redirectFailure');
        } else {
            $redirectFailure = false;
        }

        // Option d'affichage ou non du titre
        // On affiche toujours le titre quand le résultat est
        // obtenu depuis un controller
        if ($request->getQuery()->get('hasTitle') !== null) {
            $hasTitle = $request->getQuery()->get('hasTitle');
        } else {
            $hasTitle = true;
        }

        // Option d'affichage ou non du bouton de validation du formulaire
        // On afffiche toujours le bouton de validation quand le résultat est
        // obtenu depuis un controller
        if ($request->getQuery()->get('hasSubmit') !== null) {
            $hasSubmit = $request->getQuery()->get('hasSubmit');
        } else {
            $hasSubmit = true;
        }

        $redirectUrl = $this->url()->fromRoute(static::ROUTE_ADD);

        // Passage des paramètres GET
        // Ces paramètres seront stockés dans des champs <input type="hidden">
        // et renvoyés au controller via POST

        if ($redirectSuccess && !$redirectFailure) {
            $redirectUrl = $redirectUrl . '?redirectSuccess=' . $redirectSuccess;
        } elseif ($redirectFailure && !$redirectSuccess) {
            $redirectUrl = $redirectUrl . '?redirectFailure=' . $redirectFailure;
        } elseif ($redirectSuccess && $redirectFailure) {
            $redirectUrl = $redirectUrl . '?redirectSuccess=' . $redirectSuccess . '&redirectFailure=' . $redirectFailure;
        }
        
        // POST - Request - GET

        // S'il y a des variables POST, prg va les stocker
        // dans le conteneur de session et faire une
        // redirection Location 303 (instanceof Request)
        // afin d'éviter le renvoi répétitif du formulaire
        // si rafraîchissement de la page.

        // S'il n'y a pas de variables POST,
        // prg renvoie false et on affiche la
        // page (pour la première fois)


        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            
            // Redirect location
            return $prg;

        } elseif ($prg === false) {

            // Pas de données POST
            // On affiche le formulaire
            // pour la première fois
            // mais peut-être également après
            // une redirection

            // On va récupérer les messages et entrées
            // utilisateur du formulaire de connexion qui
            // ont été sauvegardés en session
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

        // prg contient les données POST
        // renvoyées par le formulaire.

        // On va les passer au service des projets
        // qui s'occupera de l'ajout

        $post = $prg;

        $project = $service->add($post);

        // Si l'ajout a échoué, le service des projets renvoie false
        // Il y a redirection selon si l'ajout a échoué ou a réussi

        $redirectSuccess = isset($prg['redirectSuccess']) ? $prg['redirectSuccess'] : null;
        $redirectFailure = isset($prg['redirectFailure']) ? $prg['redirectFailure'] : null;

        if (!$project) {

            if ($redirectFailure) {

                // On va faire une redirection "header: location"
                // vers la page de redirection d'échec
                // On stocke les données et les messages d'erreur du formulaire en session
                // pour pouvoir les récupérer après la redirection
                $form = $this->getAddForm();
                $form->saveMessages();
                $form->saveData();

                // Redirection selon l'option redirectFailure
                return $this->redirect()->toUrl($redirectFailure);

            } else {

                // On va récupérer les messages et entrées
                // utilisateur du formulaire de connexion qui
                // ont été sauvegardés en session
                $form = $this->getAddForm();
                //$form->retrieveData();
                //$form->retrieveMessages();

                // Réaffichage du formulaire d'ajout de projet
                // avec les messages d'erreurs des validateurs
                return array(
                    'addForm' => $form,
                    'hasTitle' => $hasTitle,
                    'hasSubmit' => $hasSubmit,
                    'redirectSuccess' => $redirectSuccess,
                    'redirectFailure' => $redirectFailure
                );
            }
        }

        // L'ajout a réussi
        // Redirection selon le paramètre redirectFailure
        // sinon afficher la liste des projets

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
        // Voir addAction pour les explications

        $request = $this->getRequest();
        $service = $this->getProjectService();

        // Identifiant du projet à supprimer
        // que l'on récupère depuis la route
        $id = $this->params()->fromRoute('id');

        // Option de redirection si succès de la suppression
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }

        // Url de redirection qui prend en compte les paramètres
        $redirectUrl = $this->url()->fromRoute(static::ROUTE_DELETE, array('id' => $id))
            . ($redirect ? '?redirect=' . $redirect : '');

        // Voir addAction() pour comprendre prg
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {

            // On va retourner le ViewModel
            // Pour afficher les informations du projet, on a
            // besoin de l'entité projet en variable du ViewModel
            // On fait appel au service qui va retourner un array()
            // contenant les infos projet
            $project = $service->findById($id);

            // Il se peut que le projet demandé n'existe pas
            // dans ce cas le service renvoie false
            if (!$project) {

                // \DzProjectModule\Controller\Plugin\DzProjectError est
                // un plugin de controlleur. Sa clé 'dzProjectError' est
                // définie dans le Module.php
                // Le plugin dzProjectError dispatch l'action errorAction()
                // du ProjectController en lui passant un message d'erreur
                // stocké dans la variable passée en paramètre du plugin.
                // Puis il effectue le rendu du ViewModel et retourne la
                // chaine de sortie.
                return $this->dzProjectError($this->oneNotFoundMessage);
            }

            return array(
                'project' => $project,
                'redirect' => $redirect,
            );
        }

        $post = $prg;

        // On passe l'identifiant au service des projets
        // qui va s'occuper de supprimer le projet
        // Le service retourne false si la suppression a échouée
        // true sinon

        $success = $service->delete($id);

        if (!$success) {
            // Appel au plugin de controller dzProjectError()
            return $this->dzProjectError($this->failedDeleteMessage);
        }

        // Redirection si succès de l'ajout
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

        // Redirige selon si l'on a fournit l'option redirect
        // Si non, on redirige vers la liste des projets
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
        // Type du projet à afficher
        // On peut afficher tous les projets (all),
        // ou seulement les projets actifs (active).
        // Le module Projet ne gère pas la notion
        // d'utilisateur donc on ne peut pas ici dans
        // ce module afficher les projets d'un utilisateur
        // particulier.
        $type = $this->params()
            ->fromRoute('type');

        // La vue du listing des projets affiche également
        // le formulaire d'ajout de projet sous la forme d'une
        // fenêtre bootstrap Modal. Pour le confort de l'utilisateur
        // cette fenêtre est automatiquement activée via javascript
        // si le formulaire contient des erreurs et doit-être remplit 
        // à nouveau. On a donc besoin du formulaire d'ajout de projet
        // dans le ViewModel du listing pour connaître si le formulaire
        // contient des erreurs.

        $addForm = $this->getAddForm();
        $addForm->retrieveMessages(false);
        $addForm->retrieveData(false);

        // Les méthodes retrieveMessages() et retrieveData() du
        // formulaire d'ajout de projet ont un 1er paramètre facultatif
        // "flush", qui vaut true par défaut, et qui provoque la suppression
        // respectivement des messages et des données du formulaire qui ont
        // été stockés en session. Ici il est important de mettre ce paramètre
        // à false puisque on va appeller le formulaire d'ajout de projet via
        // le widget dzProjectAddWidget() qui, en éxécutant l'action addAction()
        // du controller va également provoquer la récupération des messages et
        // des données. Il faut donc ne pas les effacer.

        // On recherche des projets selon leur type
        // Pour cela on fait notre demande auprès du service
        // de projets
        $projects = $this->getProjectService()->findByType($type);

        if (!$projects) {
            return $this->dzProjectError($this->manyNotFoundMessage);
        }

        // On peut décider de ne jamais afficher les boutons de suppression
        // des projets sur le listing des projets. Pour cela il suffit de
        // mettre l'option project_list_has_delete_action à false
        $hasDeleteAction = $this->getOptions()->getProjectListHasDeleteAction();

        // On peut décider de ne jamais afficher le bouton d'ajout
        // de projet sur le listing des projets. Pour cela il suffit de
        // mettre l'option project_list_has_add_action à false
        $hasAddAction = $this->getOptions()->getProjectListHasAddAction();

        // Pour que l'on puisse personnaliser au maximum le listing des projets
        // on passe par une variable listFields qui contient un plan du listing
        // avec chacune de ses valeurs. La personne qui voudrait réutiliser ce 
        // module peut écouter l'événement initListFields et ajouter, modifier
        // ou supprimer des champs et des valeurs du listing.
        // TODO : Implémenter le listFields dans une classe.
        $fields = array();
        $fields[0] = array('heading' => 'Désignation');
        $fields[1] = array('heading' => 'Période');

        foreach ($projects as $p) {
            $fields[0]['values'][$p['project_id']] = $p['display_name'];
            $fields[1]['values'][$p['project_id']] = $p['begin_date'] . ' - ' . $p['end_date'];
        }

        // On sauvegarde nos modification dans le controller
        $this->setListFields($fields);

        // On déclenche l'événement initListFields en passant les projets en paramètre
        // Dans un callback d'événement, on peut récupérer le listFields via la méthode getListFields()
        // de la cible ( $e->getTarget() ) de l'événement.
        $this->getEventManager()->trigger('initListFields', $this, array('projects' => $projects));
        
        // Après une éventuelle modification, on récupère les champs 
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
