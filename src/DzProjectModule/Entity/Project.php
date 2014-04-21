<?php

/**
 * Fichier de source de l'entité projet.
 *
 * PHP version 5.4.0
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Doctrine Projet.
 *
 * @category Source
 * @package  DzProjectModule\Entity
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project extends ProjectMappedSuperclass
{
}
