<?php

/**
 * Fichier source pour le AddWidgetFactory.
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

use DzProjectModule\View\Helper\AddWidget;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe AddWidgetFactory.
 *
 * Classe usine pour le widget d'affichage
 * du formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\View\Helper\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddWidgetFactory implements FactoryInterface
{
	/**
     * Cré et retourne le widget d'affichage
     * du formulaire d'ajout de projet.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return AddWidget
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $locator    = $serviceLocator->getServiceLocator();

        $viewModels = $locator->get('ViewModelManager');
        $options = $locator->get('DzProjectModule\ModuleOptions');

        $viewModel    = $viewModels->get('DzProjectModule\AddViewModel');
        $viewTemplate = $options->getProjectAddWidgetViewTemplate();

        if ($viewTemplate != '') {
            $viewModel->setTemplate($viewTemplate);
        }

        $widget = new AddWidget;
        $widget->setViewModel($viewModel);
        
        return $widget;
    }
}