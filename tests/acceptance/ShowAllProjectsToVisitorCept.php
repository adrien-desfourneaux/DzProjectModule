<?php

/**
 * Test d'acceptation ShowAllProjectsToVisitor
 * Afficher tous les projets au visiteur.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/acceptance/ShowAllProjectsToVisitorCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Voir tous les projets');

$I->haveInDatabase(
    'project', array(
        'project_id'   => '1',
        'display_name' => 'Mon super module',
        'begin_date'   => '0',        // 1er Janvier 1970
        'end_date'     => '946684800' // 1er Janvier 2000
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '2',
        'display_name' => 'Ma super application ZF2',
        'begin_date'   => '977702400', // 25 Décembre 2000
        'end_date'     => '978220800'  // 31 Décembre 2000
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '3',
        'display_name' => 'Ma super application Symfony2',
        'begin_date'   => '1355266800', // 12 Décembre 2012
        'end_date'     => '1356044400'  // 21 Décembre 2012 <= fin du monde
    )
);

$I->amOnPage('/dzproject/show-all/all');

$I->see('Projets');

$I->see('Nom');
$I->see('Période');

$I->see('Mon super module');
$I->see('01/01/1970');
$I->see('01/01/2000');

$I->see('Ma super application ZF2');
$I->see('25/12/2000');
$I->see('31/12/2000');

$I->see('Ma super application Symfony2');
$I->see('12/12/2012');
$I->see('21/12/2012');
