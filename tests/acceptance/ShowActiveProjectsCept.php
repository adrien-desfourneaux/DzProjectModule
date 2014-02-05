<?php

/**
 * Test d'acceptation ShowActiveProjects
 * Afficher les projets actifs.
 *
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Acceptance
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/acceptance/ShowActiveProjectsCept.php
 */

$I = new WebGuy($scenario);
$I->wantTo('Voir les projets actifs');

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

$I->haveInDatabase(
    'project', array(
        'project_id'   => '1',
        'display_name' => 'Projet terminé',
        'begin_date'   => $twoDaysBefore,
        'end_date'     => $oneDayBefore
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '2',
        'display_name' => "Projet qui se termine aujourd'hui",
        'begin_date'   => $oneDayBefore,
        'end_date'     => $today
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '3',
        'display_name' => "Projet qui débute aujourd'hui",
        'begin_date'   => $today,
        'end_date'     => $oneDayAfter
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '4',
        'display_name' => 'Projet actif #1',
        'begin_date'   => $twoDaysBefore,
        'end_date'     => $twoDaysAfter
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '5',
        'display_name' => 'Projet actif #2',
        'begin_date'   => $oneDayBefore,
        'end_date'     => $oneDayAfter
    )
);

$I->haveInDatabase(
    'project', array(
        'project_id'   => '6',
        'display_name' => 'Projet non débuté',
        'begin_date'   => $oneDayAfter,
        'end_date'     => $twoDaysAfter
    )
);

$I->amOnPage('/project/show-all/active');

$I->see('Projets');

$I->see('Désignation');
$I->see('Période');

$I->dontSee('Projet terminé');
$I->dontSee('Projet non débuté');

$I->see("Projet qui se termine aujourd'hui");
$I->see(strftime("%d/%m/%Y", $oneDayBefore));
$I->see(strftime("%d/%m/%Y", $today));

$I->see("Projet qui débute aujourd'hui");
$I->see(strftime("%d/%m/%Y", $today));
$I->see(strftime("%d/%m/%Y", $oneDayAfter));

$I->see('Projet actif #1');
$I->see(strftime("%d/%m/%Y", $twoDaysBefore));
$I->see(strftime("%d/%m/%Y", $twoDaysAfter));

$I->see('Projet actif #2');
$I->see(strftime("%d/%m/%Y", $oneDayBefore));
$I->see(strftime("%d/%m/%Y", $oneDayAfter));
