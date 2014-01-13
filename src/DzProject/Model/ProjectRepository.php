<?php

/**
* ProjectRepository source
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject\Model
 * @category   Source
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject\Model;

use Doctrine\ORM\EntityManager;

/**
 * Repository pour les projets.
 *
 * @see EntityManagerAwareInterface
 */
class ProjectRepository implements
    EntityManagerAwareInterface
{
    /**
     * Entity class.
     * @var string
     */
    protected $entity;

    /**
     * Constructeur de ProjectRepository.
     * @var string
     */
    public function __construct()
    {
        $this->entity = 'DzProject\Model\Project';
    }

    // EntityManager {{{
    /**
     * Doctrine ORM EntityManager.
     * @var EntityManager
     */
    protected $em;

    /**
     * Définit l'EntityManager.
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

    /**
     * Obtient le Repository.
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()
                    ->getRepository($this->entity);
    }

    /**
     * Trouve tous les projets.
     *
     */
    public function findAllProjects()
    {
        return $this->getRepository()
                    ->findAll();
    }

    /**
     * Trouve les projets actifs.
     * Un projet est actif quand la date du jour se trouve
     * entre la date de début et la date de fin du projet.
     *
     */
    public function findActiveProjects()
    {
        $today = new \DateTime();
        return $this->getEntityManager()
                    ->createQuery('SELECT p FROM DzProject\Model\Project p WHERE p.beginDate <= :today AND (p.endDate = :today OR p.endDate >= :today)')
                    ->setParameter('today', $today->getTimestamp())
                    ->getResult();
    }
}
