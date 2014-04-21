<?php

/**
 * Fichier source pour le DeleteWidgetFactory.
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

use DzProjectModule\View\Helper\DeleteWidget;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe DeleteWidgetFactory.
 *
 * Classe usine pour le widget d'affichage
 * du formulaire de suppression de projet.
 *
 * @category Source
 * @package  DzProjectModule\View\Helper\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class DeleteWidgetFactory implements FactoryInterface
{
	/**
     * Cré et retourne le widget d'affichage
     * du formulaire de suppression de projet.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return DeleteWidget
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $locator    = $serviceLocator->getServiceLocator();
        
        $viewModels = $locator->get('ViewModelManager');
        $options    = $locator->get('DzProjectModule\ModuleOptions');

        $viewModel    = $viewModels->get('DzProjectModule\DeleteViewModel');
        $viewTemplate = $options->getProjectDeleteWidgetViewTemplate();

        if ($viewTemplate != '') {
            $viewModel->setTemplate($viewTemplate);
        }

        $widget = new DeleteWidget;
        $widget->setViewModel($viewModel);
        
        return $widget;
    }
}