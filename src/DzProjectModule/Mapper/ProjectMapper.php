<?php

/**
 * Fichier de source pour le ProjectMapper
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

use DzServiceModule\Mapper\DoctrineEntityMapper;

/**
 * Mapper pour les projets.
 *
 * @category Source
 * @package  DzProjectModule\Mapper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://github.com/dieze/DzProjectModule
 */
class ProjectMapper extends DoctrineEntityMapper implements ProjectMapperInterface
{
    /**
     * Trouve un projet selon son id.
     *
     * @param integer $id Identifiant du projet à trouver
     *
     * @return mixed
     */
    public function findById($id)
    {
        $repository = $this->getRepository();
        $project = $repository->findOneByProjectId($id);

        return $project;
    }

    /**
     * Trouve un projet selon son type.
     *
     * @param string $type Type de projet à trouver
     *
     * @return ArrayCollection
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
