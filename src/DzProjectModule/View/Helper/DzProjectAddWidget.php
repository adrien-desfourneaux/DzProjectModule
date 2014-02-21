<?php

/**
 * Fichier de source du DzProjectModuleAddWidget
 * Widget qui affiche le formulaire d'Ajout de projet
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/DzProjectModuleAddWidget.php
 */

namespace DzProjectModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use DzProjectModule\Controller\ProjectController;
use Zend\Stdlib\Response;

/**
 * Widget d'affichage du formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/DzProjectModuleAddWidget.php
 */
class DzProjectAddWidget extends AbstractHelper
{
    /**
     * Contrôleur de projet
     * @var ProjectController
     */
    protected $projectController;

    /**
     * Template de vue pour le widget d'affichage
     * du formulaire d'ajout de projet
     *
     * @var string Template à utiliser
     */
    protected $viewTemplate;

    /**
     * __invoke
     *
     * @param array $options array of options
     *
     * @access public
     *
     * @return mixed
     */
    public function __invoke($options = array())
    {
        // Option de rendu ou non du VueModel
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }

        // Option de redirection en cas de succès
        if (array_key_exists('redirectSuccess', $options)) {
            $redirectSuccess = $options['redirectSuccess'];
        } else {
            $redirectSuccess = false;
        }

        // Option de redirection en cas d'échec
        if (array_key_exists('redirectFailure', $options)) {
            $redirectFailure = $options['redirectFailure'];
        } else {
            $redirectFailure = false;
        }

        // Option d'affichage ou non du titre
        if (array_key_exists('hasTitle', $options)) {
            $hasTitle = $options['hasTitle'];
        } else {
            $hasTitle = true;
        }

        // Option d'affichage ou non du bouton de validation du formulaire
        // On peut ne pas vouloir le bouton de validation par exemple
        // quand on veut intégrer le widget dans une fenêtre Modale Bootstrap.
        // On n'affiche pas le bouton de validation, mais on met un bouton
        // en footer de la fenêtre qui active le formulaire via javascript
        if (array_key_exists('hasSubmit', $options)) {
            $hasSubmit = $options['hasSubmit'];
        } else {
            $hasSubmit = true;
        }

        // Pour éviter la duplication de code on exécute
        // directement l'action du controlleur

        $projectController = $this->getProjectController();

        // On simule le passage des paramètres au controlleur via la méthode GET

        if ($redirectSuccess) {
            $projectController->getRequest()->getQuery()->set('redirectSuccess', $redirectSuccess);
        }

        if ($redirectFailure) {
            $projectController->getRequest()->getQuery()->set('redirectFailure', $redirectFailure);
        }

        $projectController->getRequest()->getQuery()->set('hasTitle', $hasTitle);
        $projectController->getRequest()->getQuery()->set('hasSubmit', $hasSubmit);

        $response = $projectController->addAction();

        // Le controlleur peut renvoyer 3 types de réponses
        // Un array qui contient les variables du futur ViewModel
        // Une instance de ViewModel
        // Une réponse Response. C'est par exemple le cas pour une
        // redirection Location 303

        if (is_array($response)) {
            $viewModel = new ViewModel($response);
        } elseif ($response instanceof ViewModel) {
            $viewModel = $response;
        } elseif ($response instanceof Response) {
            return $response;
        }

        // On fais savoir à la vue que l'on est un widget
        // et on définit le template de vue. Le template
        // de vue peut-être personnalisé via l'option
        // 'project_add_widget_view_template' dans le module.config.php
        // dans le Module.php ou dans un fichier placé dans /config/autoload

        $viewModel->setVariable('isWidget', true)
            ->setTemplate($this->viewTemplate);

        if ($render) {
            return $this->getView()->render($viewModel);
        } else {
            return $viewModel;
        }
    }

    /**
     * Définit le contrôleur de projets
     * Injection du contrôleur de projets
     *
     * @param ProjectController $projectController Contrôleur de projets
     *
     * @return DzProjectModuleAddWidget
     */
    public function setProjectController($projectController)
    {
        $this->projectController = $projectController;

        return $this;
    }

    /**
     * Obtient le contrôleur de projets
     *
     * @return ProjectController
     */
    public function getProjectController()
    {
        return $this->projectController;
    }

    /**
     * Définit le template de vue pour le widget d'affichage du formulaire d'ajout de projet
     *
     * @param string $viewTemplate Nouveau template de vue
     *
     * @return DzProjectAddWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;

        return $this;
    }
}
