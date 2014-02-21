<?php

/**
 * Fichier de source pour le RouteName ViewHelper
 * Renvoi le nom de la route courante
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/RouteName.php
 */

namespace DzProject\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Router\RouteMatch;

/**
 * Classe d'aide de vue RouteName
 * Renvoi le nom de la route courante
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/RouteName.php
 */
class RouteName extends AbstractHelper
{
    /**
     * Route qui a répondu à la requête HTTP
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * Constructeur de l'aide de vue RouteName
     *
     * @param RouteMatch $routeMatch Route qui a répondu à la requête HTTP
     *
     * @return void
     */
    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    /**
     * Méthode appelée lorsqu'un script tente d'appeler cet objet comme une fonction.
     *
     * @return string Nom de la route courante
     */
    public function __invoke()
    {
        if ($this->routeMatch) {
            $routeName = $this->routeMatch->getMatchedRouteName();

            return $routeName;
        }
    }
}
