<?php

/**
 * Test d'acceptation DeleteProject
 * Suppression d'un projet.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProjectModule/blob/master/tests/acceptance/DeleteProjectCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Supprimer un projet');

$I->haveInDatabase(
    'project', array(
        'project_id'   => '100',
        'display_name' => 'Mon super module',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

$I->amOnPage('/project/delete/100');

$I->see("Mon super module");
$I->click("Supprimer");

$I->dontSeeInDatabase(
    'project', array(
        'project_id'   => '100',
    )
);

$I->amOnPage('/project/delete/100');

$I->see("Erreur");