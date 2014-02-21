<?php

/**
 * Fichier de module de DzProjectModule
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/Module.php
 */

namespace DzProjectModule;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Session\Container as SessionContainer;

/**
 * Classe module de DzProjectModule.
 *
 * @category Source
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/Module.php
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerPluginProviderInterface,
    ViewHelperProviderInterface,
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
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
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
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'dzProjectError' => 'DzProjectModule\Controller\Plugin\DzProjectError',
            )
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
                'dzProjectListWidget' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator();

                    $viewTemplate = $locator->get('dzproject_module_options')->getProjectListWidgetViewTemplate();
                    $projectController = $locator->get('controllerloader')->get('dzproject');
                    $projectController->setEvent($locator->get('application')->getMvcEvent());

                    $viewHelper = new View\Helper\DzProjectListWidget;
                    $viewHelper->setViewTemplate($viewTemplate);
                    $viewHelper->setProjectController($projectController);

                    return $viewHelper;
                },
                'dzProjectAddWidget' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator();

                    $viewTemplate = $locator->get('dzproject_module_options')->getProjectAddWidgetViewTemplate();
                    $projectController = $locator->get('controllerloader')->get('dzproject');
                    $projectController->setEvent($locator->get('application')->getMvcEvent());

                    $viewHelper = new View\Helper\DzProjectAddWidget;
                    $viewHelper->setViewTemplate($viewTemplate);
                    $viewHelper->setProjectController($projectController);

                    return $viewHelper;
                },
                'dzProjectDeleteWidget' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator();

                    $viewTemplate = $locator->get('dzproject_module_options')->getProjectDeleteWidgetViewTemplate();
                    $projectController = $locator->get('controllerloader')->get('dzproject');
                    $projectController->setEvent($locator->get('application')->getMvcEvent());

                    $viewHelper = new View\Helper\DzProjectDeleteWidget;
                    $viewHelper->setViewTemplate($viewTemplate);
                    $viewHelper->setProjectController($projectController);

                    return $viewHelper;
                },
                'routeName' => function ($sm) {
                    $match = $sm->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
                    $viewHelper = new View\Helper\RouteName($match);

                    return $viewHelper;
                },
                'routeParam' => function ($sm) {
                    $match = $sm->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
                    $viewHelper = new View\Helper\RouteParam($match);

                    return $viewHelper;
                },
                'currentUrl' => function ($serviceManager) {
                    $request = $serviceManager->getServiceLocator()->get('request');
                    $viewHelper = new View\Helper\CurrentUrl($request);
                    return $viewHelper;
                },
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
            'invokables' => array(
                'dzproject_project_service' => 'DzProjectModule\Service\Project',
            ),
            'factories' => array(
                'dzproject_module_options' => function ($serviceManager) {
                    $config = $serviceManager->get('Config');

                    return new Options\ModuleOptions(isset($config['dzproject']) ? $config['dzproject'] : array());
                },

                'dzproject_project_mapper' => function ($serviceManager) {
                    $options = $serviceManager->get('dzproject_module_options');
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $entityClass = $options->getProjectEntityClass();

                    return new Mapper\Project($entityManager, $entityClass);
                },

                'dzproject_project_hydrator' => function ($serviceManager) {
                    $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();

                    // hydratation
                    $hydrator->addStrategy('beginDate', new \DzProjectModule\Hydrator\Strategy\DateStrTimestamp);
                    $hydrator->addStrategy('endDate', new \DzProjectModule\Hydrator\Strategy\DateStrTimestamp);

                    // extraction
                    $hydrator->addStrategy('begin_date', new \DzProjectModule\Hydrator\Strategy\DateStrTimestamp);
                    $hydrator->addStrategy('end_date', new \DzProjectModule\Hydrator\Strategy\DateStrTimestamp);

                    return $hydrator;
                },

                'dzproject_add_form' => function ($serviceManager) {
                    $form = new Form\Add(null);
                    $form->setInputFilter(new Form\AddFilter());
                    $form->setHydrator($serviceManager->get('dzproject_project_hydrator'));
                    $form->setSessionContainer(new SessionContainer('dzproject'));

                    return $form;
                },
            ),
        );
    }
}
