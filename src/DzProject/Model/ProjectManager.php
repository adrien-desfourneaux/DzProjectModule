<?php

/**
 * ProjectManager source
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject
 * @subpackage Model
 * @category   Source
 */

namespace DzProject\Model;

use Doctrine\ORM\EntityManager;

/**
 * Manager pour les projets.
 *
 * @see EntityManagerAwareInterface
 */
class ProjectManager implements
    EntityManagerAwareInterface
{
    // EntityManager {{{
    /**
     * Doctrine ORM EntityManager.
     * @var EntityManager
     */
    protected $em;

    /**
     * Définit l'EntityManager.
     *
     * @param EntityManager $em
     * @return $this
     */ 
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * Obtient l'EntityManager.
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
    // }}}
}
