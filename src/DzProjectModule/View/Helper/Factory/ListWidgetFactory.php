<?php

/**
 * Fichier source pour le ListWidgetFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Helper\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\View\Helper\Factory;

use DzProjectModule\View\Helper\ListWidget;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe ListWidgetFactory.
 *
 * Classe usine pour le widget d'affichage
 * du listing des projets.
 *
 * @category Source
 * @package  DzProjectModule\View\Helper\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ListWidgetFactory implements FactoryInterface
{
	/**
     * Cré et retourne le widget d'affichage
     * du listing des projets.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return ListWidget
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $locator    = $serviceLocator->getServiceLocator();
        
        $viewModels = $locator->get('ViewModelManager');
        $options    = $locator->get('DzProjectModule\ModuleOptions');

        $viewModel    = $viewModels->get('DzProjectModule\ListViewModel');
        $viewTemplate = $options->getProjectListWidgetViewTemplate();

        if ($viewTemplate != '') {
            $viewModel->setTemplate($viewTemplate);
        }

        $widget = new ListWidget;
        $widget->setViewModel($viewModel);
        
        return $widget;
    }
}