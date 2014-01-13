<?php

/**
 * ProjectManager specification
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject\Model
 * @category   Spec
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

namespace spec\DzProject\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Classe de spécification du comportement
 * du manager pour les projets.
 *
 * @see ObjectBehavior
 */
class ProjectManagerSpec extends ObjectBehavior
{
    /**
     * Instancie l'objet testé.
     *
     * @param \Doctrine\ORM\EntityManager    $em   Objet mock de EntityManager.
     */
    function let($em)
    {
        $this->setEntityManager($em);
    }

    /**
     * Le ProjectManager doit être initialisable.
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Model\ProjectManager');
    }
}
