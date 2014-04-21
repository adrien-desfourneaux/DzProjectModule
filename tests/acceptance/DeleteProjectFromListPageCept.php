<?php

/**
 * Test d'acceptation DeleteProjectFromListPage
 * Suppression d'un projet depuis la page de listing des projets.
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
$I->wantTo('Supprimer un projet depuis la page de listing des projets');

$I->haveDefaultProjectsInDatabase();

$I->canSeeInDatabase(
    'project', array(
        'display_name' => 'Projet actif 1'
    )
);

$I->amOnPage('/project/list/all');

$I->canSee('Projet actif 1');

$target = $I->queryXpath("//span[text()='Projet actif 1']/ancestor::tr//button[contains(concat(' ', normalize-space(@class), ' '), ' deleteAction ')]/@data-target");
$target = substr($target, 1);

// Click sur le bouton de suppression du Projet actif 1
$I->click("//span[text()='Projet actif 1']/ancestor::tr//button[contains(concat(' ', normalize-space(@class), ' '), ' deleteAction ')]");
$I->waitForElementVisible("#" . $target, 30);
$I->click("Annuler", "#" . $target);

$I->canSeeInCurrentUrl("/project/list");

$I->click("//span[text()='Projet actif 1']/ancestor::tr//button[contains(concat(' ', normalize-space(@class), ' '), ' deleteAction ')]");
$I->waitForElementVisible("#" . $target, 30);
$I->click("Supprimer", "#" . $target);

$I->canSeeInCurrentUrl("/project/list");

$I->cantSee("Projet actif 1");
$I->cantSeeInDatabase(
    'project', array(
        'display_name' => 'Project actif 1'
    )
);