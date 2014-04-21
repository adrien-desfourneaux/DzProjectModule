<?php

/**
 * Fichier d'interface pour les options du ProjectController
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
 * Interface pour les options du ProjectController
*
 * @category Source
 * @package  DzProjectModule\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
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
