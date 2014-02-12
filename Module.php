<?php

/**
 * Fichier de module de DzProject
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/Module.php
 */

namespace DzProject;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Classe module de DzProject.
 *
 * @category Source
 * @package  DzProject
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/Module.php
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
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

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'dzProjectShowAllWidget' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator();
                    $viewHelper = new View\Helper\DzProjectShowAllWidget;
                    $viewHelper->setViewTemplate($locator->get('dzproject_module_options')->getProjectShowallWidgetViewTemplate());
                    $viewHelper->setProjectService($locator->get('dzproject_project_service'));
                    return $viewHelper;
                },
                'dzProjectAddWidget' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator();
                    $viewHelper = new View\Helper\DzProjectAddWidget;
                    $viewHelper->setViewTemplate($locator->get('dzproject_module_options')->getProjectAddWidgetViewTemplate());
                    $viewHelper->setProjectController($locator->get('controllerloader')->get('dzproject'));
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
                'dzproject_project_service' => 'DzProject\Service\Project',
                'dzproject_add_form_hydrator' => 'Zend\Stdlib\Hydrator\ClassMethods'
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

                'dzproject_add_form' => function ($serviceManager) {
                    $form = new Form\Add(null);
                    $form->setInputFilter(new Form\AddFilter());
                    return $form;
                },

                'dzproject_project_hydrator' => function ($serviceManager) {
                    $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
                    return $hydrator;
                },
            ),
        );
    }
}
