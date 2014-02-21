<?php

/**
 * Test d'acceptation AddProject
 * Ajout d'un projet.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProjectModule/blob/master/tests/acceptance/AddProjectCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Ajouter un projet');

$I->dontSeeInDatabase(
    'project', array(
        'display_name' => 'Mon super module',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

$I->amOnPage('/project/add');

$I->see("Ajout d'un projet");

$I->see("Désignation");
$I->see("Date de début");
$I->see("Date de fin");

// Aucun champ remplit

$I->fillField("input[name='displayName']", "Mon super module");
$I->fillField("input[name='beginDate']", "01/01/1970");
$I->fillField("input[name='endDate']", "01/01/2000");

$I->click("button[type='submit']");

$I->seeInDatabase(
    'project', array(
        'display_name' => 'Mon super module'
    )
);
