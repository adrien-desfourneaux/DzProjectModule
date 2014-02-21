<?php

/**
 * Fichier d'interface pour les options du ProjectController
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectControllerOptionsInterface.php
 */

namespace DzProjectModule\Options;

/**
 * Interface pour les options du ProjectController
*
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Options/ProjectControllerOptionsInterface.php
 */
interface ProjectControllerOptionsInterface
{
    /**
     * Définit s'il faut utiliser le paramètre redirect
     * s'il est présent
     *
     * @param bool $useRedirectParameterIfPresent Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent);

    /**
     * Obtient s'il faut utiliser le paramètre redirect
     * s'il est présent
     *
     * @return bool
     */
    public function getUseRedirectParameterIfPresent();
}
