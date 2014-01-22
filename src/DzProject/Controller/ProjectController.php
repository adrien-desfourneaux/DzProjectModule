<?php
/**
 * ProjectController source
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

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Exception;

use DzProject\Service\ProjectService;

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

        if ($type == 'all') {
            $projects = $this->getServiceLocator()
                ->get('dzproject_service')
                ->getRepository()
                ->findAllProjects();
        } else if ($type == 'active') {
            $projects = $this->getServiceLocator()
                ->get('dzproject_service')
                ->getRepository()
                ->findActiveProjects();
        }

        return new ViewModel(
            array(
                'projects' => $projects
            )
        );
    }
}
