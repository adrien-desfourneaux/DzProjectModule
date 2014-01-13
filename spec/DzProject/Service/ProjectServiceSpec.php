<?php

/**
 * ProjectService specification
 * @author     Adrien Desfourneaux
 * @package    DzProject\Service
 * @category   Spec
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace spec\DzProject\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du
 * service pour les projets.
 * 
 */
class ProjectServiceSpec extends ObjectBehavior
{
    /**
     * Initialisation des spécifications.
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sl
     * @param \Doctrine\ORM\EntityManager                  $em
     */
    function let($sl, $em)
    {
        $this->setServiceLocator($sl);
        $sl->get('doctrine.entitymanager.orm_default')
           ->willReturn($em);
    }

    /**
     * Le ProjectService doit être initialisable.
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Service\ProjectService');
    }

    /**
     * Le ProjectService doit contenir le ServiceLocator.
     *
     */
    function it_should_contain_service_locator()
    {
        $this->getServiceLocator()
             ->shouldReturnAnInstanceOf('Zend\ServiceManager\ServiceLocatorInterface');
    }

    /**
     * Le ProjectService doit contenir le ProjectManager.
     *
     */
    function it_should_contain_project_manager()
    {
        $this->getManager()
             ->shouldReturnAnInstanceOf('DzProject\Model\ProjectManager');
    }

    /**
     * Le ProjectService doit contenir le ProjectRepository.
     *
     */
    function it_should_contain_project_repository()
    {
        $this->getRepository()
             ->shouldReturnAnInstanceOf('DzProject\Model\ProjectRepository');
    }
}
