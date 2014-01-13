<?php

/**
 * ShowActiveProjectsToVisitor acceptance test
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject
 * @subpackage Acceptance
 * @category   Test
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

$I = new WebGuy($scenario);
$I->wantTo('See active projects');

$twoDaysBefore = new \DateTime(); $twoDaysBefore->modify('-2 days');
$oneDayBefore  = new \DateTime(); $oneDayBefore->modify('-1 day');
$today         = new \DateTime();
$oneDayAfter   = new \DateTime(); $oneDayAfter->modify('+1 day');
$twoDaysAfter  = new \DateTime(); $twoDaysAfter->modify('+2 days');

$I->haveInDatabase('project', array(
    'project_id'   => '1',
    'display_name' => 'Finished project',
    'begin_date'   => $twoDaysBefore->getTimestamp(),
    'end_date'     => $oneDayBefore->getTimestamp()
));

$I->haveInDatabase('project', array(
    'project_id'   => '2',
    'display_name' => 'Project that finish today',
    'begin_date'   => $oneDayBefore->getTimestamp(),
    'end_date'     => $today->getTimestamp()
));

$I->haveInDatabase('project', array(
    'project_id'   => '3',
    'display_name' => 'Project that start today',
    'begin_date'   => $today->getTimestamp(),
    'end_date'     => $oneDayAfter->getTimestamp()
));

$I->haveInDatabase('project', array(
    'project_id'   => '4',
    'display_name' => 'Active project #1',
    'begin_date'   => $twoDaysBefore->getTimestamp(),
    'end_date'     => $twoDaysAfter->getTimestamp()
));

$I->haveInDatabase('project', array(
    'project_id'   => '5',
    'display_name' => 'Active project #2',
    'begin_date'   => $oneDayBefore->getTimestamp(),
    'end_date'     => $oneDayAfter->getTimestamp()
));

$I->haveInDatabase('project', array(
    'project_id'   => '6',
    'display_name' => 'Non started project',
    'begin_date'   => $oneDayAfter->getTimestamp(),
    'end_date'     => $twoDaysAfter->getTimestamp()
));

$I->amOnPage('/project/show-all/active');

$I->see('Projects');

$I->see('Name');
$I->see('Period');

$I->dontSee('Finished project');
$I->dontSee('Non started project');

$I->see('Project that finish today');
$I->see(strftime("%d/%m/%Y", $oneDayBefore->getTimestamp()));
$I->see(strftime("%d/%m/%Y", $today->getTimestamp()));

$I->see('Project that start today');
$I->see(strftime("%d/%m/%Y", $today->getTimestamp()));
$I->see(strftime("%d/%m/%Y", $oneDayAfter->getTimestamp()));

$I->see('Active project #1');
$I->see(strftime("%d/%m/%Y", $twoDaysBefore->getTimestamp()));
$I->see(strftime("%d/%m/%Y", $twoDaysAfter->getTimestamp()));

$I->see('Active project #2');
$I->see(strftime("%d/%m/%Y", $oneDayBefore->getTimestamp()));
$I->see(strftime("%d/%m/%Y", $oneDayAfter->getTimestamp()));
