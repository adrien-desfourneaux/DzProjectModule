<?php

/**
 * Fichier source pour le AddFormFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Form\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Form\Factory;

use DzProjectModule\Form\AddForm;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe AddFormFactory.
 *
 * Classe usine pour le formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\Form\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddFormFactory implements FactoryInterface
{
	/**
     * Cré et retourne le formulaire d'ajout de projet.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return AddForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new AddForm;

        $locator   = $serviceLocator->getServiceLocator();
        $hydrators = $locator->get('HydratorManager');
        $filters   = $locator->get('InputFilterManager');

        $filter    = $filters->get('DzProjectModule\AddInputFilter');
        $hydrator  = $hydrators->get('DzProjectModule\ProjectHydrator');
        $container = $locator->get('DzProjectModule\SessionContainer');

        $form->setInputFilter($filter);
        $form->setHydrator($hydrator);
        $form->setContainer($container);

        return $form;
    }
}