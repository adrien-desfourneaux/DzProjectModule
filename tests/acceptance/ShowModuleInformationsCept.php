<?php

/**
 * ShowModuleInformations acceptance test
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/acceptance/ShowModuleInformationsCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('See Module Informations');
$I->amOnPage('/project');

$I->see('DzProject Module');
$I->see('Author');
$I->see('Repository');
