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
class WebHelper extends \Codeception\Module
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
        $sql = file_get_contents(__DIR__ . '/../../data/dzproject.dump.sqlite.sql');

        preg_match_all("/INSERT INTO '?project'? .*?;/s", $sql, $matches);
        $inserts = $matches[0];

        foreach ($inserts as $insert) {
            $dbh->exec($insert);
        }
    }
}
