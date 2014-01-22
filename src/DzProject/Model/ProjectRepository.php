<?php

/**
 * ProjectRepository source
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Model/ProjectRepository.php
 */

namespace DzProject\Model;

use Doctrine\ORM\EntityManager;

/**
 * Repository pour les projets.
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Model/ProjectRepository.php
 */
class ProjectRepository
{
    /**
     * Entity class.
     * @var string
     */
    protected $entity;

    /**
     * Doctrine ORM EntityManager.
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Constructeur de ProjectRepository.
     *
     * @param EntityManager $entityManager Instance of EntityManager
     */
    public function __construct($entityManager)
    {
        $this->entity        = 'DzProject\Model\Project';
        $this->entityManager = $entityManager;
    }

    /**
     * Obtient le Repository.
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->entityManager
            ->getRepository($this->entity);
    }

    /**
     * Trouve tous les projets.
     *
     * @return ArrayCollection
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
     * @return ArrayCollection
     */
    public function findActiveProjects()
    {
        return $this->entityManager
            ->createQuery(
                'SELECT p FROM DzProject\Model\Project p ' .
                'WHERE p._beginDate <= :today AND p._endDate >= :today'
            )
            ->setParameter('today', strtotime(date("y-m-d")))
            ->getResult();
    }
}
