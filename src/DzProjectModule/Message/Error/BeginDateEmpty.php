<?php

/**
 * Fichier source pour le BeginDateEmpty.
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
 * Classe de message BeginDateEmpty.
 *
 * Message d'erreur quand le champ date de début du projet
 * est vide lors de l'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class BeginDateEmpty extends FieldValueEmpty
{
	public function __construct()
	{
		parent::__construct();
		$this->setContent("La date de début ne doit pas être vide");
	}
}