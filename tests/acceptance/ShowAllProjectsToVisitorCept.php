<?php

/**
 * ShowAllProjectsToVisitor acceptance test
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject
 * @subpackage Acceptance
 * @category   Test
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

$I = new WebGuy($scenario);
$I->wantTo('See all projects');
$I->amOnPage('/project/show-all/all');

$I->see('Project');
$I->see('Description');
$I->see('Period');
