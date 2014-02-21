<?php

/**
 * Fichier de source pour le RouteParam ViewHelper
 * Renvoi le paramètre demandé de la route courante
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/RouteParam.php
 */

namespace DzProject\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Router\RouteMatch;

/**
 * Classe d'aide de vue RouteParam
 * Renvoi le paramètre demandé de la route courante
 *
 * @category Source
 * @package  DzProject\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/View/Helper/RouteParam.php
 */
class RouteParam extends AbstractHelper
{
    /**
     * Route qui a répondu à la requête HTTP
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * Constructeur de l'aide de vue RouteParam
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
     * @param string $name Nom du paramètre à récupérer
     *
     * @return mixed
     */
    public function __invoke($name = null)
    {
        if ($this->routeMatch) {

            if ($name !== null) {
                $routeParam = $this->routeMatch->getParam($name);

                return $routeParam;
            } else {
                return $this;
            }
        }
    }

    /**
     * Obtient les paramètres de la route courante
     * dans un array
     *
     * @return array
     */
    public function getParams()
    {
        return $this->routeMatch->getParams();
    }
}
