<?php

/**
 * Fichier de source du DzProjectAddWidget
 * Widget qui affiche le formulaire d'Ajout de projet
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectAddWidget.php
 */

namespace DzProject\View\Helper;

use DzProject\Options\ProjectControllerOptionsInterface;
use DzProject\Service;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use DzProject\Controller\ProjectController;

/**
 * Widget d'affichage du formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectAddWidget.php
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
     * @return string
     */
    public function __invoke($options = array())
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

        $projectController = $this->getProjectController();

        if ($redirect) {
            $projectController->getRequest()->getQuery()->set('redirect', $redirect);
        }
        
        $viewModel = new ViewModel($this->getProjectController()->addAction());
        
        $viewModel->setTemplate($this->viewTemplate);
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
     * @return DzProjectAddWidget
     */
    public function setProjectController($projectController)
    {
        $this->projectController = $projectController;
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
     * Définit le template de vue pour le widget d'affichage de plusieurs projets
     *
     * @param string $viewTemplate Nouveau template de vue
     *
     * @return DzProjectShowAllWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
