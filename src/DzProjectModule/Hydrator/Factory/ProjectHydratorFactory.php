<?php

/**
 * Fichier source pour le ProjectHydratorFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Hydrator\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Hydrator\Factory;

use DzProjectModule\Hydrator\ProjectHydrator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe ProjectHydratorFactory.
 *
 * Classe usine pour l'hydrateur de projets.
 *
 * @category Source
 * @package  DzProjectModule\Hydrator\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectHydratorFactory implements FactoryInterface
{
    /**
     * Classe hydrateur à instancier.
     *
     * @var string
     */
    const HYDRATOR_CLASS = 'DzProjectModule\Hydrator\ProjectHydrator';

	/**
     * Cré et retourne l'hydrateur de projets.
     *
     * Ajoute des stratégies à l'hydrateur de projets pour
     * manipuler les dates commes des chaînes de caractères
     * et pouvoir en même temps les stocker sous la forme
     * de timestamps.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return ProjectHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $class = static::HYDRATOR_CLASS;
        $hydrator = new $class;

        $locator  = $serviceLocator->getServiceLocator();
        $strategy = $locator->get('DzBaseModule\DateStrTimestampStrategy');

        // hydratation
        $hydrator->addStrategy('beginDate', $strategy);
        $hydrator->addStrategy('endDate', $strategy);

        // extraction
        $hydrator->addStrategy('begin_date', $strategy);
        $hydrator->addStrategy('end_date', $strategy);

        return $hydrator;
    }
}