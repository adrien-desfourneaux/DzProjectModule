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

$time          = new \DateTime();
$twoDaysBefore = strtotime(date('y-m-d', $time->modify('-2 days')->getTimestamp()));

$oneDayBefore = new \DateTime();
$oneDayBefore  = strtotime(date('y-m-d', $time->modify('-1 days')->getTimestamp()));

$time          = new \DateTime();
$today         = strtotime(date('y-m-d', $time->getTimestamp()));

$time          = new \DateTime();
$oneDayAfter   = strtotime(date('y-m-d', $time->modify('+1 day')->getTimestamp()));

$time          = new \DateTime();
$twoDaysAfter  = strtotime(date('y-m-d', $time->modify('+2 days')->getTimestamp()));

$I->haveInDatabase('project', array(
    'project_id'   => '1',
    'display_name' => 'Finished project',
    'begin_date'   => $twoDaysBefore,
    'end_date'     => $oneDayBefore
));

$I->haveInDatabase('project', array(
    'project_id'   => '2',
    'display_name' => 'Project that finish today',
    'begin_date'   => $oneDayBefore,
    'end_date'     => $today
));

$I->haveInDatabase('project', array(
    'project_id'   => '3',
    'display_name' => 'Project that start today',
    'begin_date'   => $today,
    'end_date'     => $oneDayAfter
));

$I->haveInDatabase('project', array(
    'project_id'   => '4',
    'display_name' => 'Active project #1',
    'begin_date'   => $twoDaysBefore,
    'end_date'     => $twoDaysAfter
));

$I->haveInDatabase('project', array(
    'project_id'   => '5',
    'display_name' => 'Active project #2',
    'begin_date'   => $oneDayBefore,
    'end_date'     => $oneDayAfter
));

$I->haveInDatabase('project', array(
    'project_id'   => '6',
    'display_name' => 'Non started project',
    'begin_date'   => $oneDayAfter,
    'end_date'     => $twoDaysAfter
));

$I->amOnPage('/project/show-all/active');

$I->see('Projects');

$I->see('Name');
$I->see('Period');

$I->dontSee('Finished project');
$I->dontSee('Non started project');

$I->see('Project that finish today');
$I->see(strftime("%d/%m/%Y", $oneDayBefore));
$I->see(strftime("%d/%m/%Y", $today));

$I->see('Project that start today');
$I->see(strftime("%d/%m/%Y", $today));
$I->see(strftime("%d/%m/%Y", $oneDayAfter));

$I->see('Active project #1');
$I->see(strftime("%d/%m/%Y", $twoDaysBefore));
$I->see(strftime("%d/%m/%Y", $twoDaysAfter));

$I->see('Active project #2');
$I->see(strftime("%d/%m/%Y", $oneDayBefore));
$I->see(strftime("%d/%m/%Y", $oneDayAfter));
