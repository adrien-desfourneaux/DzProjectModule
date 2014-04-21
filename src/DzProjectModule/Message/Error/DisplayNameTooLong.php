<?php

/**
 * Fichier source pour le DisplayNameTooLong.
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

use DzMessageModule\Message\Error\FieldValueTooLong;

/**
 * Classe de message DisplayNameTooLong.
 *
 * Message d'erreur quand le champ désignation du projet
 * est trop long lors de l'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class DisplayNameTooLong extends FieldValueTooLong
{
	public function __construct()
	{
		parent::__construct();
		$this->setContent("La désignation ne doit pas excéder 200 caractères.");
	}
}