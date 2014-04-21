<?php

/**
 * Fichier source pour le message d'erreur d'une suppression de projet échouée.
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

use DzMessageModule\Message\Error\DeleteFailed;

/**
 * Classe de message d'une suppression de projet échouée.
 *
 * @category Source
 * @package  DzProjectModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectDeleteFailed extends DeleteFailed
{
	public function __construct()
	{
		parent::__construct();
		$this->setContent("La suppression du projet a échouée.");
	}
}