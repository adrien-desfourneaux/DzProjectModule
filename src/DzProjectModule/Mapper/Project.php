<?php

/**
 * Fichier de source pour le ProjectMapper
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Mapper/Project.php
 */

namespace DzProjectModule\Mapper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Mapper pour les projets.
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Mapper/Project.php
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
    public function __construct($entityManager, $entityClass = 'DzProjectModule\Entity\Project')
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
     * Trouve un projet selon son id.
     *
     * @param integer $id Identifiant du projet à trouver
     *
     * @return mixed
     */
    public function findById($id)
    {
        $project = $this->getRepository()->findOneByProjectId($id);
        return $project;
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

    /**
     * Insère un nouveau projet dans le média de stockage
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à insérer
     *
     * @return void
     */
    public function insert($entity)
    {
        return $this->persist($entity);
    }

    /**
     * Met à jour un projet existant
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à mettre à jour
     *
     * @return void
     */
    public function update($entity)
    {
        return $this->persist($entity);
    }

    /**
     * Supprime un projet
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à supprimer
     *
     * @return void
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Persiste un projet en base de données
     *
     * @param \DzProjectModule\Entity\Project $entity Entité projet à persister
     *
     * @return \DzProjectModule\Entity\Project
     */
    protected function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
