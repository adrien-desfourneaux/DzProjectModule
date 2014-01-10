<?php

/**
 * ProjectController specification
 * @author     Adrien Desfourneaux
 * @package    DzProject\Controller
 * @category   Spec
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace spec\DzProject\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du
 * contrôleur de projet ProjectController.
 * 
 */
class ProjectControllerSpec extends ObjectBehavior
{
    /** 
     * Initialisation des spécifications.
     * 
     * @param Zend\Mvc\Controller\PluginManager  $plugins Objet mock de PluginManager.
     * @param Zend\Mvc\Controller\Plugin\Params  $params  Objet mock de Params.
     */
    public function let($plugins, $params)
    {
        $this->setPluginManager($plugins);

        $plugins->setController(Argument::any())
                ->willReturn($plugins);

        $plugins->get('params', Argument::cetera())
                ->willReturn($params);
    }

    /**
     * Le ProjectController doit être initialisable.
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Controller\ProjectController');
    }

    /**
     * Le ProjectController doit répondre à
     * l'action index.
     *
     */
    function it_responds_to_index_action()
    {
        $this->indexAction()
             ->shouldReturnAnInstanceOf('Zend\View\Model\ViewModel');
    }

    /**
     * Le ProjectController doit répondre à 
     * l'action showall avec le paramètre de route all.
     *
     * @param Zend\Mvc\Controller\Plugin\Params $params Objet mock de Params.
     */
    function it_responds_to_showall_action_with_route_parameter_all($params)
    {
        $params->fromRoute('type')
               ->shouldBeCalled()
               ->willReturn('all');

        $this->showallAction()
             ->shouldReturnAnInstanceOf('Zend\View\Model\ViewModel');
    }
}
