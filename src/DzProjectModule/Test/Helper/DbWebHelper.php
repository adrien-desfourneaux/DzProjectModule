<?php

/**
 * Classe pour WebHelper qui utilise les méthodes de Db
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Test\Helper;

use Codeception\Module\Db as DbModule;

/**
 * Classe pour WebHelper qui utilise les méthodes de Db
 *
 * @category Source
 * @package  DzProjectModule\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class DbWebHelper implements DbWebHelperInterface
{
    /**
     * Module Codeception de base de données.
     *
     * @var DbModule
     */
    protected $db;

    /**
     * Constructeur de DbWebHelper.
     *
     * @param DbModule $db Module de Base de données.
     *
     * @return void
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function haveDefaultProjectsInDatabase()
    {
        $dbh = $this->db->dbh;
        $db = new Db($dbh);
        $db->insertProjects();
    }

    /**
     * Définit tout par défaut
     * dans la base de données.
     *
     * @return void
     */
    public function haveAllProjectDefaultsInDatabase()
    {
        $dbh = $this->db->dbh;
        $db = new Db($dbh);
        $db->execDumpFile();
    }
}
