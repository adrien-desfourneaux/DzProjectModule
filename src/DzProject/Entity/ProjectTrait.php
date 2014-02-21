<?php

/**
 * Trait pour l'entité projet
 * Utile pour les entités Doctrine, car il n'est pas
 * possible de faire un extends d'une classe entité Doctrine
 *
 * PHP version 5.4.0
 *
 * @category Source
 * @package  DzProject\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Entity/ProjectTrait.php
 */

namespace DzProject\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Exception;

/**
 * Trait pour l'entité projet
 * Utile pour les entités Doctrine, car il n'est pas
 * possible de faire un extends d'une classe entité Doctrine
 *
 * @category Source
 * @package  DzProject\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Entity/ProjectTrait.php
 *
 */
trait ProjectTrait
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
     * Obtient l'id projet.
     *
     * @return integer
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Définit le nom d'affichage.
     *
     * @param string $displayName Display name to set
     *
     * @return ProjectInterface
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
     * Obtient le nom d'affichage.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Définit la date de début.
     *
     * @param integer $beginDate Begin date to set
     *
     * @return ProjectInterface
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
     * Obtient la date de début.
     *
     * @return integer
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Définit la date de fin.
     *
     * @param integer $endDate End date to set
     *
     * @return ProjectInterface
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
     * Obtient la date de fin.
     *
     * @return integer
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
