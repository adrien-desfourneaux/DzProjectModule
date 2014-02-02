<?php

/**
 * Fichier de source pour le ProjectMapper
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Mapper/Project.php
 */

namespace DzProject\Mapper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Mapper pour les projets.
 *
 * @category Source
 * @package  DzProject\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Mapper/Project.php
 */
class Project implements ProjectInterface
{
    /**
     * Doctrine ORM EntityManager.
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Entity class.
     * @var string
     */
    protected $entityClass;

    /**
     * Constructeur de ProjectMapper.
     *
     * @param EntityManager $entityManager Instance de EntityManager
     * @param string        $entityClass   Nom de la classe de l'entité projet
     */
    public function __construct($entityManager, $entityClass = 'DzProject\Entity\Project')
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }

    /**
     * Obtient le Repository.
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->entityManager
            ->getRepository($this->entityClass);
    }

    /**
     * Trouve un projet selon son type.
     *
     * @param string $type Type de projet à trouver
     *
     * @return \Doctrine\ORM\Common\Collections\ArrayCollection
     */
    public function findByType($type)
    {
        if ($type == 'active') {
            return $this->findActive();
        } else {
            return $this->findAll();
        }
    }

    /**
     * Trouve tous les projets.
     *
     * @return ArrayCollection
     */
    public function findAll()
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
    public function findActive()
    {
        return $this->entityManager
            ->createQuery(
                'SELECT p FROM ' . $this->entityClass . ' p ' .
                'WHERE p.beginDate <= :today AND p.endDate >= :today'
            )
            ->setParameter('today', strtotime(date("y-m-d")))
            ->getResult();
    }
}
