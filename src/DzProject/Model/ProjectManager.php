<?php

/**
 * ProjectManager source
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Model/ProjectManager.php
 */

namespace DzProject\Model;

use Doctrine\ORM\EntityManager;

/**
 * Manager pour les projets.
 *
 * @category Source
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/src/DzProject/Model/ProjectManager.php
 */
class ProjectManager
{
    /**
     * Doctrine ORM EntityManager.
     * @var EntityManager
     */
    protected $em;

    /**
     * Construct a new instance of ProjectManager
     *
     * @param EntityManager $em Instance of EntityManager
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
}
