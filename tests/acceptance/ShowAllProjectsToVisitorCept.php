<?php

/**
 * ShowAllProjectsToVisitor acceptance test
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
$I->wantTo('See all projects');

$I->haveInDatabase(
    'project', array(
        'project_id'   => '1',
        'display_name' => 'My great module',
        'begin_date'   => '0',        // January, 1st 1970
        'end_date'     => '946684800' // January, 1st 2000
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '2',
        'display_name' => 'My great ZF2 application',
        'begin_date'   => '977702400', // December, 25th 2000
        'end_date'     => '978220800'  // December, 31th 2000
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '3',
        'display_name' => 'My great Symfony2 application',
        'begin_date'   => '1355266800', // December, 12th 2012
        'end_date'     => '1356044400'  // December, 21th 2012 <= end of world
    )
);

$I->amOnPage('/project/show-all/all');

$I->see('Projects');

$I->see('Name');
$I->see('Period');

$I->see('My great module');
$I->see('01/01/1970');
$I->see('01/01/2000');

$I->see('My great ZF2 application');
$I->see('25/12/2000');
$I->see('31/12/2000');

$I->see('My great Symfony2 application');
$I->see('12/12/2012');
$I->see('21/12/2012');
