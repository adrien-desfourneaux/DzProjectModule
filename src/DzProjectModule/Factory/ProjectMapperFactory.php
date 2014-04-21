<?php

/**
 * Fichier source pour le ProjectMapperFactory.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Factory;

use DzProjectModule\Mapper\ProjectMapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe ProjectMapperFactory.
 *
 * Classe usine pour le mappeur de projets.
 *
 * @category Source
 * @package  DzProjectModule\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectMapperFactory implements FactoryInterface
{
    /**
     * Classe à instancier pour créer le mapper.
     *
     * @var string
     */
    const MAPPER_CLASS = 'DzProjectModule\Mapper\ProjectMapper';

	/**
     * Cré et retourne le mappeur de projets.
     *
     * @param  ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return ProjectMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$options = $serviceLocator->get('DzProjectModule\ModuleOptions');
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $entityClass = $options->getProjectEntityClass();

        $class = static::MAPPER_CLASS;
        $mapper = new $class($entityManager);
        $mapper->setEntityClass($entityClass);

        return $mapper;
    }
}