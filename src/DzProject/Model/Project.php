<?php

/**
 * Project entity
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject\Model
 * @category   Source
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace DzProject\Model;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Exception;

/**
 * Project
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
    private $projectId;

    /**
     * Nom d'affichage du projet.
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=50, unique=true, nullable=false)
     */
    private $displayName;

    /**
     * Date de début du projet.
     * @var integer
     *
     * @ORM\Column(name="begin_date", type="integer", nullable=false)
     */
    private $beginDate;

    /**
     * Date de fin du projet.
     * @var integer
     *
     * @ORM\Column(name="end_date", type="integer", nullable=false)
     */
    private $endDate;



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
     * @param string $displayName
     * @return Project
     */
    public function setDisplayName($displayName)
    {
        if(!is_string($displayName)) 
            throw new Exception\InvalidArgumentException();

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
     * @param integer $beginDate
     * @return Project
     */
    public function setBeginDate($beginDate)
    {
        if(!is_int($beginDate))
            throw new Exception\InvalidArgumentException();

        if(!is_null($this->endDate) && $beginDate > $this->endDate)
            throw new Exception\LogicException();

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
     * @param integer $endDate
     * @return Project
     */
    public function setEndDate($endDate)
    {
        if(!is_int($endDate))
            throw new Exception\InvalidArgumentException();

        if(!is_null($this->beginDate) && $endDate < $this->beginDate)
            throw new Exception\LogicException();
        
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
