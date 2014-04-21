<?php

/**
 * Fichier de superclasse mappée pour l'entité Projet.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Stdlib\Exception;

/**
 * Superclasse mappée Doctrine pour l'entité Projet.
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://github.com/dieze/DzProjectModule
 *
 * @ORM\MappedSuperclass
 */
class ProjectMappedSuperclass implements ProjectInterface
{
    /**
     * Identifiant du projet.
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $projectId;

    /**
     * Nom d'affichage du projet.
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=50, unique=true, nullable=false)
     */
    protected $displayName;

    /**
     * Date de début du projet.
     * @var integer
     *
     * @ORM\Column(name="begin_date", type="integer", nullable=false)
     */
    protected $beginDate;

    /**
     * Date de fin du projet.
     * @var integer
     *
     * @ORM\Column(name="end_date", type="integer", nullable=false)
     */
    protected $endDate;

    /**
     * {@inheritdoc}
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName($displayName)
    {
        if (!is_string($displayName)) {
            throw new Exception\InvalidArgumentException('Argument invalide : displayName = ' . $displayName);
        }

        $this->displayName = $displayName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function setBeginDate($beginDate)
    {
        if (!is_numeric($beginDate) || is_float($beginDate)) {
            throw new Exception\InvalidArgumentException('Argument invalide : beginDate = ' . $beginDate);
        } elseif (!is_null($this->endDate) && $beginDate > $this->endDate) {
            throw new Exception\LogicException('La date de début (beginDate = ' . $beginDate . ') est postérieure à la date de fin (endDate = ' . $this->endDate . ')');
        }

        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate($endDate)
    {
        if (!is_numeric($endDate) || is_float($endDate)) {
            throw new Exception\InvalidArgumentException('Argument invalide : endDate = ' . $endDate);
        } elseif (!is_null($this->beginDate) && $endDate < $this->beginDate) {
            throw new Exception\LogicException('La date de fin (endDate = ' . $endDate . ') est antérieure à la date de début (beginDate = ' . $this->beginDate . ')');
        }

        $this->endDate = $endDate;

        return $this;
    }

    /**
     * {@ineritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
