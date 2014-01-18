<?php

/**
 * Project entity
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Model/Project.php
 */

namespace DzProject\Model;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Exception;

/**
 * Project
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Model/Project.php
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
{
    /**
     * Identifiant du projet.
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $_projectId;

    /**
     * Nom d'affichage du projet.
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=50, unique=true, nullable=false)
     */
    private $_displayName;

    /**
     * Date de début du projet.
     * @var integer
     *
     * @ORM\Column(name="begin_date", type="integer", nullable=false)
     */
    private $_beginDate;

    /**
     * Date de fin du projet.
     * @var integer
     *
     * @ORM\Column(name="end_date", type="integer", nullable=false)
     */
    private $_endDate;



    /**
     * Obtient l'id projet.
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->_projectId;
    }

    /**
     * Définit le nom d'affichage.
     *
     * @param string $displayName Display name to set
     *
     * @return Project
     */
    public function setDisplayName($displayName)
    {
        if (!is_string($displayName)) {
            throw new Exception\InvalidArgumentException();
        }

        $this->_displayName = $displayName;

        return $this;
    }

    /**
     * Obtient le nom d'affichage.
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->_displayName;
    }

    /**
     * Définit la date de début.
     *
     * @param integer $beginDate Begin date to set
     *
     * @return Project
     */
    public function setBeginDate($beginDate)
    {
        if (!is_int($beginDate)) {
            throw new Exception\InvalidArgumentException();
        } else if (!is_null($this->_endDate) && $beginDate > $this->_endDate) {
            throw new Exception\LogicException();
        }

        $this->_beginDate = $beginDate;

        return $this;
    }

    /**
     * Obtient la date de début.
     *
     * @return integer 
     */
    public function getBeginDate()
    {
        return $this->_beginDate;
    }

    /**
     * Définit la date de fin.
     *
     * @param integer $endDate End date to set
     *
     * @return Project
     */
    public function setEndDate($endDate)
    {
        if (!is_int($endDate)) {
            throw new Exception\InvalidArgumentException();
        } else if (!is_null($this->_beginDate) && $endDate < $this->_beginDate) {
            throw new Exception\LogicException();
        }
        
        $this->_endDate = $endDate;

        return $this;
    }

    /**
     * Obtient la date de fin.
     *
     * @return integer 
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }
}
