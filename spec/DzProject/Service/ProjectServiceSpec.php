<?php

/**
 * ProjectService specification
 *
 * PHP version 5.3.3
 *
 * @category Spec
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/spec/DzProject/Service/ProjectServiceSpec.php
 */

namespace spec\DzProject\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du
 * service pour les projets.
 * 
 * @category Spec
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/spec/DzProject/Service/ProjectServiceSpec.php
 */
class ProjectServiceSpec extends ObjectBehavior
{
    /**
     * Initialisation des spécifications.
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sl Mock instance of ServiceLocator
     * @param \Doctrine\ORM\EntityManager                  $em Mock instance of EntityManager
     * @param \DzProject\Model\ProjectManager              $pm Mock instance of ProjectManager
     * @param \DzProject\Model\ProjectRepository           $pr Mock instance of ProjectRepository
     *
     * @return null
     */
    function let($sl, $em, $pm, $pr)
    {
        $this->beConstructedWith($pm, $pr);

        $this->setServiceLocator($sl);
        $sl->get('doctrine.entitymanager.orm_default')
            ->willReturn($em);
    }

    /**
     * Le ProjectService doit être initialisable.
     *
     * @return null
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Service\ProjectService');
    }

    /**
     * Le ProjectService doit contenir le ServiceLocator.
     *
     * @return null
     */
    function it_should_contain_service_locator()
    {
        $this->getServiceLocator()
            ->shouldReturnAnInstanceOf('Zend\ServiceManager\ServiceLocatorInterface');
    }

    /**
     * Le ProjectService doit contenir le ProjectManager.
     *
     * @return null
     */
    function it_should_contain_project_manager()
    {
        $this->getManager()
            ->shouldReturnAnInstanceOf('DzProject\Model\ProjectManager');
    }

    /**
     * Le ProjectService doit contenir le ProjectRepository.
     *
     * @return null
     */
    function it_should_contain_project_repository()
    {
        $this->getRepository()
            ->shouldReturnAnInstanceOf('DzProject\Model\ProjectRepository');
    }
}
