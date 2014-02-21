<?php

/**
 * Interface pour l'entité projet
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Entity/ProjectInterface.php
 */

namespace DzProject\Entity;

/**
 * Interface pour l'entité projet
 *
 * @category Source
 * @package  DzProject\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Entity/ProjectInterface.php
 */
interface ProjectInterface
{
	/**
     * Obtient l'id projet.
     *
     * @return integer
     */
    public function getProjectId();

    /**
     * Définit le nom d'affichage.
     *
     * @param string $displayName Display name to set
     *
     * @return ProjectInterface
     */
    public function setDisplayName($displayName);

    /**
     * Obtient le nom d'affichage.
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Définit la date de début.
     *
     * @param integer $beginDate Begin date to set
     *
     * @return ProjectInterface
     */
    public function setBeginDate($beginDate);

    /**
     * Obtient la date de début.
     *
     * @return integer
     */
    public function getBeginDate();

    /**
     * Définit la date de fin.
     *
     * @param integer $endDate End date to set
     *
     * @return ProjectInterface
     */
    public function setEndDate($endDate);

    /**
     * Obtient la date de fin.
     *
     * @return integer
     */
    public function getEndDate();
}