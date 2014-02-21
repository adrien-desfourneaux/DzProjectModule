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
     * Trouve un projet selon son id.
     *
     * @param integer $id Identifiant du projet à trouver
     *
     * @return mixed
     */
    public function findById($id)
    {
        $project = $this->getRepository()->findOneByProjectId($id);
        if ($project == null) {
            throw new \Exception("L'entité Project d'identifiant projectId = " . $id . " n'a pas été trouvée");
        }

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
     * @param \DzProject\Entity\Project $entity Entité projet à insérer
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
     * @param \DzProject\Entity\Project $entity Entité projet à mettre à jour
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
     * @param integer $id Identifiant du projet à supprimer
     *
     * @return void
     */
    public function delete($id)
    {
        $project = $this->findById($id);
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    /**
     * Persiste un projet en base de données
     *
     * @param \DzProject\Entity\Project $entity Entité projet à persister
     *
     * @return \DzProject\Entity\Project
     */
    protected function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
