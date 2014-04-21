<?php

/**
 * Interface pour WebHelper qui utilise les méthodes de Db
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

/**
 * Interface pour WebHelper qui utilise les méthodes de Db
 *
 * @category Source
 * @package  DzProjectModule\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
interface DbWebHelperInterface
{
	/**
     * Insère les projets par défaut
     * dans la base de données
     *
     * @return void
     */
    public function haveDefaultProjectsInDatabase();

    /**
     * Définit tout par défaut
     * dans la base de données.
     *
     * @return void
     */
    public function haveAllProjectDefaultsInDatabase();
}