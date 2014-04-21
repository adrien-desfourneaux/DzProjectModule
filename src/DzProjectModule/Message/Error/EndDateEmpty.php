<?php

/**
 * Fichier source pour le EndDateEmpty.
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

use DzMessageModule\Message\Error\FieldValueEmpty;

/**
 * Classe de message EndDateEmpty.
 *
 * Message d'erreur quand le champ date de fin du projet
 * est vide lors de l'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class EndDateEmpty extends FieldValueEmpty
{
	public function __construct()
	{
		parent::__construct();
		$this->setContent("La date de fin ne doit pas être vide");
	}
}