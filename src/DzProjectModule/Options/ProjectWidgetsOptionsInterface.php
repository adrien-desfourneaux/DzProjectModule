<?php

/**
 * Fichier d'interface pour les options des widgets
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectWidgetsOptionsInterface.php
 */

namespace DzProjectModule\Options;

/**
 * Interface pour les options des widgets
*
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectWidgetsOptionsInterface.php
 */
interface ProjectWidgetsOptionsInterface
{
    /**
     * Définit le template de vue pour le widget de listing des projets
     *
     * @param string $projectListWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectListWidgetViewTemplate($projectListWidgetViewTemplate);

    /**
     * Obtient le template de vue pour le widget de listing des projets
     *
     * @return string
     */
    public function getProjectListWidgetViewTemplate();

    /**
     * Définit le template de vue pour le widget d'affichage du formulaire d'ajout de projet
     *
     * @param string $projectAddWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectAddWidgetViewTemplate($projectAddWidgetViewTemplate);

    /**
     * Obtient le template de vue pour le widget d'affichage du formulaire d'ajout de projet
     *
     * @return string
     */
    public function getProjectAddWidgetViewTemplate();

    /**
     * Définit le template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @param string $projectDeleteWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectDeleteWidgetViewTemplate($projectDeleteWidgetViewTemplate);

    /**
     * Obtient le template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @return string
     */
    public function getProjectDeleteWidgetViewTemplate();
}
