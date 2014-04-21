<?php

/**
 * Test d'acceptation AddProject
 * Ajout d'un projet.
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
$I->wantTo('Ajouter un projet');

$I->dontSeeInDatabase(
    'project', array(
        'display_name' => 'Nouveau projet',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

$I->amOnPage('/project/add');

$I->canSee("Ajout d'un projet");

$I->canSee("Désignation");
$I->canSee("Date de début");
$I->canSee("Date de fin");

// Aucun champ remplit
$I->click("button[type='submit']");
$I->canSeeInCurrentUrl('/project/add');
$I->canSee('La désignation ne doit pas être vide');
$I->canSee('La date de début ne doit pas être vide');
$I->canSee('La date de fin ne doit pas être vide');
$I->canSee('Date invalide, doit être jj/mm/aaaa');

// Dates invalides
$I->fillField("input[name='displayName']", "Nouveau projet");
$I->fillField("input[name='beginDate']", "01234");
$I->fillField("input[name='endDate']", "56789");
$I->click("button[type='submit']");
$I->canSeeInCurrentUrl('/project/add');
$I->canSee('Date invalide, doit être jj/mm/aaaa');

// Date de fin antérieure à la date de début
$I->fillField("input[name='displayName']", "Nouveau projet");
$I->fillField("input[name='beginDate']", "01/01/2000");
$I->fillField("input[name='endDate']", "01/01/1970");
$I->click("button[type='submit']");
$I->canSeeInCurrentUrl('/project/add');
$I->canSee('La date de fin doit être postérieure à la date de début');

// Ajout du projet
$I->fillField("input[name='displayName']", "Nouveau projet");
$I->fillField("input[name='beginDate']", "01/01/1970");
$I->fillField("input[name='endDate']", "01/01/2000");
$I->click("button[type='submit']");

$I->canSeeInDatabase(
    'project', array(
        'display_name' => 'Nouveau projet',
        'begin_date'   => '0',
        'end_date'     => '946684800'
    )
);
