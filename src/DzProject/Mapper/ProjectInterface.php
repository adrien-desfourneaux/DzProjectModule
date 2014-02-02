<?php

/**
 * Fichier de source pour le ProjectInterface
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Mapper/ProjectInterface.php
 */

namespace DzProject\Mapper;

/**
 * Interface pour le mapper de projet
 *
 * @category Source
 * @package  DzProject\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Mapper/ProjectInterface.php
 */
interface ProjectInterface
{
    /**
     * Trouve un  projet selon son type
     *
     * @param string $type Type de projet à trouver
     *
     * @return \Doctrine\ORM\Common\Collections\ArrayCollection
     */
    public function findByType($type);

    /**
     * Trouve tous les projets
     *
     * @return \Doctrine\ORM\Common\Collections\ArrayCollection
     */
    public function findAll();

    /**
     * Trouve les projets actifs
     *
     * @return \Doctrine\ORM\Common\Collections\ArrayCollection
     */
    public function findActive();
}
