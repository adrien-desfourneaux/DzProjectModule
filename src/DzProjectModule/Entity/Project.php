<?php

/**
 * Fichier de source de l'entité projet
 *
 * PHP version 5.4.0
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Entity/Project.php
 */

namespace DzProjectModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Entity/Project.php
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project implements ProjectInterface
{
    use ProjectTrait;
}
