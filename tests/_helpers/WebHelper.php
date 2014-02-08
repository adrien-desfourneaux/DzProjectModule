<?php

/**
 * Aides pour les tests d'acceptation
 * 
 * PHP version 5.3.3
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Helper
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/_helpers/WebHelper.php
 */

namespace Codeception\Module;

use DzProject\Test\Helper\DbDumper;
use DzProject\Test\Helper\WebHelperDbInterface;

/**
 * Classe helper pour les tests d'acceptation.
 * Fonctions personnalisés pour le WebGuy.
 *
 * @category   Test
 * @package    DzProject
 * @subpackage Helper
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link       https://github.com/dieze/DzProject/blob/master/tests/_helpers/WebHelper.php
 */
class WebHelper extends \Codeception\Module implements WebHelperDbInterface
{
    /**
     * Insère les projets par défaut
     * dans la base de données
     *
     * @return void
     */
    public function haveDefaultProjectsInDatabase()
    {
        $dbh = $this->getModule('Db')->dbh;
        $dbDumper = new DbDumper($dbh);
        $dbDumper->insertProjects();
    }
}
