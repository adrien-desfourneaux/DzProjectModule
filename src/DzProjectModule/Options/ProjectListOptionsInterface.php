<?php

/**
 * Fichier d'interface pour les options du listing des projets
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectListOptionsInterface.php
 */

namespace DzProjectModule\Options;

/**
 * Interface pour les options du listing des projets
*
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectListOptionsInterface.php
 */
interface ProjectListOptionsInterface
{
    /**
     * Définit s'il faut afficher les actions de suppression de projet
     * dans le listing des projets
     *
     * @param bool $hasDeleteAction Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setProjectListHasDeleteAction($hasDeleteAction);

    /**
     * Obtient s'il faut afficher les actions de suppression de projet
     * dans le listing des projets
     *
     * @return bool
     */
    public function getProjectListHasDeleteAction();

    /**
     * Définit s'il faut afficher l'action d'ajout de projet
     * dans le listing des projets
     *
     * @param bool $hasAddAction Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setProjectListHasAddAction($hasAddAction);

    /**
     * Obtient s'il faut afficher l'action d'ajout de projet
     * dans le listing des projets
     *
     * @return bool
     */
    public function getProjectListHasAddAction();
}
