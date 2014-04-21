<?php

/**
 * Fichier source pour le AddInputFilterFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\InputFilter\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\InputFilter\Factory;

use DzProjectModule\InputFilter\AddInputFilter;

use DzMessageModule\InputFilter\Factory\InputFilterFactory;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe AddInputFilterFactory.
 *
 * Classe usine pour le filtre de données
 * du formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\InputFilter\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddInputFilterFactory extends InputFilterFactory
{
	/**
     * Cré et retourne le filtre de données
     * du formulaire d'ajout de projet.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return AddInputFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $filter = new AddInputFilter();

        $this->injectDependencies($filter, $serviceLocator);
        $filter->init();

        return $filter;
    }
}