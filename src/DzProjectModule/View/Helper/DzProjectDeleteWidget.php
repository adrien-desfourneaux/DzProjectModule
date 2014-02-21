<?php

/**
 * Fichier de source du DzProjectModuleDeleteWidget
 * Widget qui affiche le formulaire de suppression de projet
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/DzProjectModuleDeleteWidget.php
 */

namespace DzProjectModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use DzProjectModule\Controller\ProjectController;

/**
 * Widget d'affichage du formulaire de suppression de projet
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/DzProjectModuleDeleteWidget.php
 */
class DzProjectDeleteWidget extends AbstractHelper
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
     * @param integer $id      identifiant du projet à supprimer
     * @param array   $options array of options
     *
     * @access public
     *
     * @return mixed
     */
    public function __invoke($id, $options = array())
    {
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }

        if (array_key_exists('redirect', $options)) {
            $redirect = $options['redirect'];
        } else {
            $redirect = false;
        }

        if (array_key_exists('hasTitle', $options)) {
            $hasTitle = $options['hasTitle'];
        } else {
            $hasTitle = true;
        }

        if (array_key_exists('hasSubmit', $options)) {
            $hasSubmit = $options['hasSubmit'];
        } else {
            $hasSubmit = true;
        }

        $projectController = $this->getProjectController();
        $projectController->getEvent()->getRouteMatch()->setParam('id', $id);

        if ($redirect) {
            $projectController->getRequest()->getQuery()->set('redirect', $redirect);
        }

        $response = $projectController->deleteAction();

        if (is_array($response)) {
            $viewModel = new ViewModel($response);
        } elseif ($response instanceof ViewModel) {
            $viewModel = $response;
        } else {
            return $response;
        }

        $viewModel->setVariable('hasTitle', $hasTitle)
            ->setVariable('hasSubmit', $hasSubmit)
            ->setTemplate($this->viewTemplate);

        if ($render) {
            return $this->getView()->render($viewModel);
        } else {
            return $viewModel;
        }
    }

    /**
     * Définit le contrôleur de projets
     *
     * @param ProjectController $projectController Contrôleur de projets
     *
     * @return DzProjectModuleDeleteWidget
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
     * Définit le template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @param string $viewTemplate Nouveau template de vue
     *
     * @return DzProjectModuleDeleteWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;

        return $this;
    }
}
