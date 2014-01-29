<?php

/**
 * Fichier d'interface pour les options concernant le ProjectService
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ProjectServiceOptionsInterface.php
 */

namespace DzProject\Options;

/**
 * Interface pour les options concernant le ProjectService
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ProjectServiceOptionsInterface.php
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
