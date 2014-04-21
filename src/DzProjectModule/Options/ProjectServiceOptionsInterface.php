<?php

/**
 * Fichier d'interface pour les options concernant le ProjectService
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Options;

/**
 * Interface pour les options concernant le ProjectService
 *
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
interface ProjectServiceOptionsInterface
{
    /**
     * Définit le nom de la classe d'entité projet
     *
     * @param string $projectEntityClass Nom de la classe d'entité projet
     *
     * @return ModuleOptions
     */
    public function setProjectEntityClass($projectEntityClass);

    /**
     * Obtient le nom de la classe d'entité projet
     *
     * @return string
     */
    public function getProjectEntityClass();
}
