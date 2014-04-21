<?php

/**
 * Test d'acceptation ListAllProjects
 * Afficher tous les projets.
 *
 * PHP version 5.3.0
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link       https://github.com/dieze/DzProjectModule
 */

$I = new WebGuy($scenario);
$I->wantTo('Voir tous les projets');

// Insère les projets situés
// dans data/dzproject.dump.sqlite.sql
$I->haveAllProjectDefaultsInDatabase();

$I->amOnPage('/project/list/all');

$I->canSee('Projets');

$I->canSee('Désignation');
$I->canSee('Période');

$I->canSee('Projet non débuté');
$I->canSee("Projet qui débute aujourd'hui");
$I->canSee('Projet actif 1');
$I->canSee('Projet actif 2');
$I->canSee("Projet qui se termine aujourd'hui");
$I->canSee('Projet terminé');
