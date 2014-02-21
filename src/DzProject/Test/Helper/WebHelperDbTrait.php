<?php

/**
 * Trait pour WebHelper qui utilise les méthodes de Db
 *
 * PHP version 5.4.0
 *
 * @category Source
 * @package  DzProject\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Test/Helper/WebHelperDbTrait.php
 */

namespace DzProject\Test\Helper;

/**
 * Trait pour WebHelper qui utilise les méthodes de Db
 *
 * @category Source
 * @package  DzProject\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Test/Helper/WebHelperDbTrait.php
 */
trait WebHelperDbTrait
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
        $db = new \DzProject\Test\Helper\Db($dbh);
        $db->insertProjects();
    }

    /**
     * Définit tout par défaut
     * dans la base de données
     *
     * @return void
     */
    public function haveAllDefaultsInDatabase()
    {
        $dbh = $this->getModule('Db')->dbh;
        $db = new \DzProject\Test\Helper\Db($dbh);
        $db->execDumpFile();
    }
}
