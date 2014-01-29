<?php

/**
 * Fichier d'options pour le Module DzProject
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ModuleOptions.php
 */

namespace DzProject\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Classe d'options pour le Module DzProject
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ModuleOptions.php
 */
class ModuleOptions extends AbstractOptions implements
    ProjectServiceOptionsInterface
{
    /**
     * Nom de la classe d'entité projet
     *
     * @var string
     */
    protected $projectEntityClass = 'DzProject\Entity\Project';

    /**
     * Définit le nom de la classe d'entité projet
     *
     * @param string $projectEntityClass Nom de la classe d'entité projet
     *
     * @return ModuleOptions
     */
    public function setProjectEntityClass($projectEntityClass)
    {
        $this->projectEntityClass = $projectEntityClass;
        return $this;
    }

    /**
     * Obtient le nom de la classe d'entité projet
     *
     * @return string
     */
    public function getProjectEntityClass()
    {
        return $this->projectEntityClass;
    }
}
