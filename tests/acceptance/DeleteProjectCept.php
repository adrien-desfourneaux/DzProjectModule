<?php

/**
 * Test d'acceptation DeleteProject
 * Suppression d'un projet.
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
$I->wantTo('Supprimer un projet');

$I->haveInDatabase(
    'project', array(
        'project_id'   => '1',
        'display_name' => 'Nouveau projet',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

// Suppression du projet
$I->amOnPage('/project/delete/1');
$I->canSee("Nouveau projet");
$I->click("Supprimer");

// Projet supprimé
$I->cantSeeInDatabase(
    'project', array(
        'project_id'   => '1',
    )
);

// Projet non existant
$I->amOnPage('/project/delete/1');
$I->canSee('Erreur');
$I->canSee("Le projet demandé n'a pas été trouvé");