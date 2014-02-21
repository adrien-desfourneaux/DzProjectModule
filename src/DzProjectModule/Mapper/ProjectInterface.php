<?php

/**
 * Fichier de source pour le ProjectInterface
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Mapper/ProjectInterface.php
 */

namespace DzProjectModule\Mapper;

/**
 * Interface pour le mapper de projet
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Mapper/ProjectInterface.php
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

    /**
     * Insère un nouveau projet dans le média de stockage
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à insérer
     *
     * @return void
     */
    public function insert($entity);

    /**
     * Met à jour un projet existant
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à mettre à jour
     *
     * @return void
     */
    public function update($entity);
}