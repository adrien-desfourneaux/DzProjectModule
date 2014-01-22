<?php

/**
 * ProjectManager specification
 *
 * PHP version 5.3.3
 *
 * @category Spec
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/spec/DzProject/Model/ProjectManagerSpec.php
 */

namespace spec\DzProject\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du comportement
 * du manager pour les projets.
 *
 * @category Spec
 * @package  DzProject\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     http://github.com/dieze/DzProject/blob/master/spec/DzProject/Model/ProjectManagerSpec.php
 * @see      ObjectBehavior
 */
class ProjectManagerSpec extends ObjectBehavior
{
    /**
     * Instancie l'objet testé.
     *
     * @param \Doctrine\ORM\EntityManager $em Objet mock de EntityManager.
     *
     * @return null
     */
    function let($em)
    {
        $this->beConstructedWith($em);
    }

    /**
     * Le ProjectManager doit être initialisable.
     *
     * @return null
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Model\ProjectManager');
    }
}
