<?php

/**
 * EntityManagerAwareInterface source
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject\Model
 * @category   Source
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject\Model;

use Doctrine\ORM\EntityManager;

/**
 * Contrat d'interface pour l'injection
 * du Doctrine\ORM\EntityManager.
 *
 */
interface EntityManagerAwareInterface
{
    /**
     * Définit l'EntityManager.
     *
     * @param EntityManager $em
     * @return $this
     */ 
    public function setEntityManager(EntityManager $em);

    /**
     * Obtient l'EntityManager.
     * @return EntityManager
     */
    public function getEntityManager();
}
