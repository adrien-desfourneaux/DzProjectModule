<?php

/**
 * ProjectController source
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject\Controller
 * @category   Source
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Exception;

use DzProject\Service\ProjectService;

/**
 * Classe contrôleur de projet.
 *
 * @see AbstractActionController Contrôleur d'actions abstrait.
 */
class ProjectController extends AbstractActionController
{
    /**
     * Action par défaut du ProjectController.
     *
     * @return ViewModel Les données à retourner à la vue.
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Affichage d'un ensemble de projets.
     *
     * @return ViewModel Les données à retourner à la vue.
     */
    public function showallAction()
    {
        $type = $this->params()
                     ->fromRoute('type');

        $projects = array();

        if($type == 'all') {
            $projects = $this->getServiceLocator()
                             ->get('dzproject_service')
                             ->getRepository()
                             ->findAllProjects();
        }

        return new ViewModel(array(
            'projects' => $projects
        ));
    }
}
