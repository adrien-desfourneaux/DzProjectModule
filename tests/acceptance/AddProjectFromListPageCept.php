<?php

/**
 * Test d'acceptation AddProjectFromListPage
 * Ajout d'un projet depuis la page de listing des projets.
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
$I->wantTo('Ajouter un projet depuis la page de listing des projets');

$I->dontSeeInDatabase(
    'project', array(
        'display_name' => 'Nouveau projet',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

$I->amOnPage('/project/list/all');

$I->cantSee('Nouveau projet');

// Essai du bouton fermer
$I->click("Add");
$I->click("Fermer");
$I->canSeeInCurrentUrl('/project/list/all');

// Ajout du projet
$I->click("Add");
$I->fillField("input[name='displayName']", "Nouveau projet");
$I->fillField("input[name='beginDate']", "01/01/1970");
$I->fillField("input[name='endDate']", "01/01/2000");
$I->click("Nouveau");

$I->canSeeInCurrentUrl("/project/list");
$I->canSee("Nouveau projet");
$I->canSee("01/01/1970");
$I->canSee("01/01/2000");

$I->canSeeInDatabase(
    'project', array(
        'display_name' => 'Nouveau projet',
        'begin_date'   => '0',
        'end_date'     => '946684800'
    )
);
