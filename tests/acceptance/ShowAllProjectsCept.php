<?php

/**
 * Test d'acceptation ShowAllProjects
 * Afficher tous les projets.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/acceptance/ShowAllProjectsCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Voir tous les projets');

// Insère les projets situés
// dans data/dzproject.dump.sqlite.sql
$I->haveDefaultProjectsInDatabase();

$I->amOnPage('/project/show-all/all');

$I->see('Projets');

$I->see('Désignation');
$I->see('Période');

$I->see('Projet non débuté');
$I->see("Projet qui débute aujourd'hui");
$I->see('Projet actif 1');
$I->see('Projet actif 2');
$I->see("Projet qui se termine aujourd'hui");
$I->see('Projet terminé');