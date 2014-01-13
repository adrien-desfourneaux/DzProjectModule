<?php

/**
 * ProjectRepository specification
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
 * du repository pour les projets.
 *
 * @see ObjectBehavior
 */
class ProjectRepositorySpec extends ObjectBehavior
{
    /**
     * Instancie l'objet testé.
     *
     * @param \Doctrine\ORM\EntityManager                  $em   Objet mock de EntityManager.
     * @param \Doctrine\ORM\EntityRepository               $repo Objet mock de EntityRepository.
     */
    function let($em, $repo)
    {
        $this->setEntityManager($em);

        $em->getRepository('DzProject\Model\Project')
           ->willReturn($repo);
    }

    /**
     * Le ProjectRepository doit être initialisable.
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('DzProject\Model\ProjectRepository');
    }

    /**
     * Le ProjectRepository doit trouver tous les projets.
     *
     * @param \Doctrine\ORM\EntityRepository                $repo Objet mock de EntityRepository.
     * @param \Doctrine\Common\Collections\ArrayCollection  $coll Objet mock de ArrayCollection.
     */
    function it_finds_all_projects($repo, $coll)
    {
        $repo->findAll()
             ->shouldBeCalled()
             ->willReturn($coll);

        $this->findAllProjects()
             ->shouldReturn($coll);
    }

    /**
     * Le ProjectRepository doit trouver les projets actifs.
     * Un projet est actif quand la date du jour se trouve
     * entre la date de début et la date de fin du projet.
     *
     * @param \Doctrine\ORM\EntityManager                  $em   Objet mock de EntityManager.
     * @param \Doctrine\ORM\AbstractQuery                  $q    Objet mock de Query.
     * @param \Doctrine\Common\Collections\ArrayCollection $coll Objet mock de ArrayCollection.
     */
    function it_finds_active_projects($em, $q, $coll)
    {
        $em->createQuery(Argument::any())
           ->willReturn($q);

        $q->setParameter(Argument::cetera())
          ->willReturn($q);

        $q->getResult()
           ->willReturn($coll);

        $this->findActiveProjects()
             ->shouldReturn($coll);
    }
}
