<?php

/**
 * Fichier de source du Field.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Listing
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\View\Listing;

use DzBaseModule\View\Listing\Field as BaseField;

/**
 * Champ d'un listing.
 *
 * @category Source
 * @package  DzProjectModule\View\Listing
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class Field extends BaseField
{
	/**
	 * Constructeur d'un champ de listing.
	 *
	 * @param string $heading Titre du champ.
	 *
	 * @return void
	 */
	public function __construct($heading = null)
	{
		parent::__construct($heading);

		// Valeurs de champs utilisés
		// en plus de "heading"
		$this["href"]   = array(); // Lien de cellule
		$this["values"] = array(); // Valeur de la ligne
		$this["class"]  = array(); // Classe de cellule
	}
}