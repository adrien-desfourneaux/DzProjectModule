<?php

/**
 * Fichier de source pour le ProjectMapperInterface
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Mapper;

use Doctrine\ORM\Common\Collections\ArrayCollection;

use DzServiceModule\Mapper\EntityMapperInterface;

/**
 * Interface pour le mapper de projet
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
interface ProjectMapperInterface extends EntityMapperInterface
{
    /**
     * Trouve un projet selon son id.
     *
     * @param integer $id Identifiant du projet à trouver
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * Trouve un  projet selon son type
     *
     * @param string $type Type de projet à trouver
     *
     * @return ArrayCollection
     */
    public function findByType($type);
    
    /**
     * Trouve les projets actifs
     *
     * @return ArrayCollection
     */
    public function findActive();
}
