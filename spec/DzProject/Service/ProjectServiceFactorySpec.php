<?php

/**
 * ProjectServiceFactory specification
 *
 * PHP version 5.3.3
 *
 * @category Spec
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/spec/DzProject/Service/ProjectServiceFactorySpec.php
 */

namespace spec\DzProject\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du factory
 * qui construit le service pour les projets.
 * 
 * @category Spec
 * @package  DzProject\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/spec/DzProject/Service/ProjectServiceFactorySpec.php
 */
class ProjectServiceFactorySpec extends ObjectBehavior
{
    /**
     * Initialisation des spécifications.
     *
     * @return null
     */
    function let()
    {
    }

    /**
     * Le ProjectServiceFactory doit être initialisable.
     *
     * @return null
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Service\ProjectServiceFactory');
    }

    /**
     * Le ProjectServiceFactory crée le ProjectService
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator Mock instance of ServiceLocatorInterface
     * @param \Doctrine\ORM\EntityManagerInterface         $entityManager  Mock instance of EntityManagerInterface
     *
     * @return null
     */
    function it_create_project_service($serviceLocator, $entityManager)
    {
        $serviceLocator->get('doctrine.entitymanager.orm_default')
            ->willReturn($entityManager);
        
        $this->createService($serviceLocator)
            ->shouldReturnAnInstanceOf('DzProject\Service\ProjectService');
    }
}
