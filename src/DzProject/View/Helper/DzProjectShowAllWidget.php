<?php

/**
 * Fichier de source du DzProjectShowAllWidget
 * Widget qui affiche tous les Projets
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectShowAllWidget.php
 */

namespace DzProject\View\Helper;

use DzProject\Service;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

/**
 * Widget d'affichage de tous les projets.
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/DzProjectShowAllWidget.php
 */
class DzProjectShowAllWidget extends AbstractHelper
{
    /**
     * $var string template used for view
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

        if (array_key_exists('type', $options)) {
            $type = $options['type'];
        } else {
            $type = 'all';
        }

        $projects = $this->getProjectService()
            ->getProjectMapper()
            ->findByType($type);

        $viewModel = new ViewModel(
            array(
                'projects' => $projects,
            )
        );

        $viewModel->setTemplate('dz-project/project/showall.phtml');
        if ($render) {
            return $this->getView()->render($viewModel);
        } else {
            return $viewModel;
        }
    }

    /**
     * Définit le service pour les projets
     *
     * @param Service\Project $projectService Nouveau service pour les projets
     *
     * @return DzProjectShowAllWidget
     */
    public function setProjectService($projectService)
    {
        $this->projectService = $projectService;
        return $this;
    }

    /**
     * Obtient le service pour les projets
     *
     * @return Service\Projet
     */
    public function getProjectService()
    {
        return $this->projectService;
    }
}
