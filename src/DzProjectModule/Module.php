<?php

/**
 * Fichier de module de DzProjectModule
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule;

use DzMessageModule\ModuleManager\Feature\MessageProviderInterface;
use DzViewModule\ModuleManager\Feature\ViewModelProviderInterface;
use DzServiceModule\ModuleManager\Feature\ServicesProviderInterface;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * Classe module de DzProjectModule.
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    DependencyIndicatorInterface,
    ControllerProviderInterface,
    ViewModelProviderInterface,
    ServicesProviderInterface,
    ViewHelperProviderInterface,
    FormElementProviderInterface,
    HydratorProviderInterface,
    InputFilterProviderInterface,
    MessageProviderInterface,
    ServiceProviderInterface
{
    /**
     * Retourne un tableau à parser par Zend\Loader\AutoloaderFactory.
     *
     * @return array
     *
     * @see AutoloaderProviderInterface
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * Retourne la configuration à fusionner avec
     * la configuration de l'application
     *
     * @return array|\Traversable
     *
     * @see ConfigProviderInterface
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Doit retourner un tableau des modules auxquels celui-ci dépend.
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return array(
            'DoctrineModule',    // Doctrine Entity
            'DoctrineORMModule', // Doctrine EntityManager
            'DzMessageModule',   // InputFilter messages
            'DzViewModule',      // ViewModel Manager
            'DzServiceModule',   // Services Manager
            'DzBaseModule',      // AbstractActionController
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\ProjectController' => 'DzProjectModule\Controller\Factory\ProjectControllerFactory',
            ),
            'aliases' => array(
                'dzproject' => 'DzProjectModule\ProjectController',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewModelConfig()
    {
        return array(
            'invokables' => array(
                'DzProjectModule\AddViewModel'    => 'DzProjectModule\View\Model\AddViewModel',
                'DzProjectModule\DeleteViewModel' => 'DzProjectModule\View\Model\DeleteViewModel',
                'DzProjectModule\ListViewModel'   => 'DzProjectModule\View\Model\ListViewModel',
            ),
        );
    }

    /**
     * Doit retourner un objet \Zend\ServiceManager\Config
     * ou un tableau pour remplir un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServicesConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\ProjectService' => 'DzProjectModule\Service\Factory\ProjectServiceFactory',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\AddWidget'    => 'DzProjectModule\View\Helper\Factory\AddWidgetFactory',
                'DzProjectModule\DeleteWidget' => 'DzProjectModule\View\Helper\Factory\DeleteWidgetFactory',
                'DzProjectModule\ListWidget'   => 'DzProjectModule\View\Helper\Factory\ListWidgetFactory',
            ),
            'aliases' => array(
                'dzProjectAddWidget'    => 'DzProjectModule\AddWidget',
                'dzProjectDeleteWidget' => 'DzProjectModule\DeleteWidget',
                'dzProjectListWidget'   => 'DzProjectModule\ListWidget',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\AddForm' => 'DzProjectModule\Form\Factory\AddFormFactory',
            ),
            'shared' => array(
                'DzProjectModule\AddForm' => true,
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getHydratorConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\ProjectHydrator'  => 'DzProjectModule\Hydrator\Factory\ProjectHydratorFactory',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\AddInputFilter' => 'DzProjectModule\InputFilter\Factory\AddInputFilterFactory',
            ),
        );
    }

    /**
     * Doit retourner un objet \Zend\ServiceManager\Config
     * ou un tableau pour remplir un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getMessageConfig()
    {
        return array(
            'invokables' => array(
                'DzProjectModule\BeginDateEmpty'      => 'DzProjectModule\Message\Error\BeginDateEmpty',
                'DzProjectModule\DisplayNameEmpty'    => 'DzProjectModule\Message\Error\DisplayNameEmpty',
                'DzProjectModule\DisplayNameTooLong'  => 'DzProjectModule\Message\Error\DisplayNameTooLong',
                'DzProjectModule\EndDateEmpty'        => 'DzProjectModule\Message\Error\EndDateEmpty',
                'DzProjectModule\ProjectDeleteFailed' => 'DzProjectModule\Message\Error\ProjectDeletefailed',
                'DzProjectModule\ProjectNotFound'     => 'DzProjectModule\Message\Error\ProjectNotFound',
                'DzProjectModule\ProjectsNotFound'    => 'DzProjectModule\Message\Error\ProjectsNotFound',
            ),
            'aliases' => array(
                'begin date empty'      => 'DzProjectModule\BeginDateEmpty',
                'display name empty'    => 'DzProjectModule\DisplayNameEmpty',
                'display name too long' => 'DzProjectModule\DisplayNameTooLong',
                'end date empty'        => 'DzProjectModule\EndDateEmpty',
                'project delete failed' => 'DzProjectModule\ProjectDeleteFailed',
                'project not found'     => 'DzProjectModule\ProjectNotFound',
                'projects not found'    => 'DzProjectModule\ProjectsNotFound',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     *
     * @see ServiceProviderInterface
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'DzProjectModule\ModuleOptions'    => 'DzProjectModule\Factory\ModuleOptionsFactory',
                'DzProjectModule\ProjectMapper'    => 'DzProjectModule\Factory\ProjectMapperFactory',
                'DzProjectModule\SessionContainer' => 'DzProjectModule\Factory\SessionContainerFactory',
            ),
        );
    }
}
