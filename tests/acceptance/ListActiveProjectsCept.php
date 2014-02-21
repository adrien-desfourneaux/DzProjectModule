<?php

/**
 * Test d'acceptation ShowActiveProjects
 * Afficher les projets actifs.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProjectModule/blob/master/tests/acceptance/ShowActiveProjectsCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Voir les projets actifs');

// Insère les projets situés
// dans data/dzproject.dump.sqlite.sql
$I->haveDefaultProjectsInDatabase();

$I->amOnPage('/project/list/active');

$I->see('Projets');

$I->see('Désignation');
$I->see('Période');

$I->dontSee('Projet non débuté');
$I->see("Projet qui débute aujourd'hui");
$I->see('Projet actif 1');
$I->see('Projet actif 2');
$I->see("Projet qui se termine aujourd'hui");
$I->dontsee('Projet terminé');
