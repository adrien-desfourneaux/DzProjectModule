<?php

/**
 * Exception à envoyer si une méthode recherchée n'existe pas.
 * Est généralement envoyée depuis une méthode magique __call
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Exception
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Exception/MethodDoesNotExistException.php
 */

namespace DzProject\Exception;

/**
 * Exception à envoyer si une méthode recherchée n'existe pas.
 * Est généralement envoyée depuis une méthode magique __call
 *
 * @category Source
 * @package  DzProject\Exception
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Exception/MethodDoesNotExistException.php
 */
class MethodDoesNotExistException extends CoreException
{
}