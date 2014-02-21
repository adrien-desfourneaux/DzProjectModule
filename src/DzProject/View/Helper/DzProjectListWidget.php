<?php

/**
 * Fichier de source du DzProjectListWidget
 * Widget qui affiche tous les Projets
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectListWidget.php
 */

namespace DzProject\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Widget de listing des projets
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectListWidget.php
 */
class DzProjectListWidget extends AbstractHelper
{
    /**
     * Contrôleur de projet
     * @var ProjectController
     */
    protected $projectController;

    /**
     * Template de vue pour le widget de listing des projets
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
        if (array_key_exists('render', $options)) {
            $render = $options['render'];
        } else {
            $render = true;
        }

        if (array_key_exists('type', $options)) {
            $type = $options['type'];
        } else {
            $type = 'all';
        }

        if (array_key_exists('hasTitle', $options)) {
            $hasTitle = $options['hasTitle'];
        } else {
            $hasTitle = true;
        }

        if (array_key_exists('hasDeleteAction', $options)) {
            $hasDeleteAction = $options['hasDeleteAction'];
        } else {
            $hasDeleteAction = true;
        }

        if (array_key_exists('hasAddAction', $options)) {
            $hasAddAction = $options['hasAddAction'];
        } else {
            $hasAddAction = true;
        }

        $projectController = $this->getProjectController();
        $projectController->getEvent()->getRouteMatch()->setParam('type', $type);

        $viewModel = $projectController->listAction();

        // Il arrive que le controlleur ne renvoie pas
        // un ViewModel mais un array de variables
        if (!($viewModel instanceof ViewModel)) {
            $viewModel = new ViewModel($viewModel);
        }

        $viewModel->setVariable('hasTitle', $hasTitle)
            ->setVariable('hasDeleteAction', $hasDeleteAction)
            ->setVariable('hasAddAction', $hasAddAction)
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
     * @return DzProjectDeleteWidget
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
     * Définit le template de vue pour le widget de listing des projets
     *
     * @param string $viewTemplate Nouveau template de vue
     *
     * @return DzProjectListWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;

        return $this;
    }
}
