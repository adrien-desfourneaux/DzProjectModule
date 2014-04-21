<?php

/**
 * Fichier source pour le message d'erreur ProjectNotFound.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Message\Error;

use DzMessageModule\Message\Error\ElementNotFound;

/**
 * Classe de message d'erreur ProjectNotFound.
 *
 * @category Source
 * @package  DzProjectModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectNotFound extends ElementNotFound
{
	public function __construct()
	{
		parent::__construct();
		$this->setContent("Le projet demandé n'a pas été trouvé.");
	}
}