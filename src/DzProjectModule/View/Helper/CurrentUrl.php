<?php

/**
 * Fichier de source pour le CurrentUrl ViewHelper
 * Renvoi l'url courante
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/CurrentUrl.php
 */

namespace DzProjectModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

/**
 * Classe d'aide de vue CurrentUrl
 * Renvoi l'url courante
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/View/Helper/CurrentUrl.php
 */
class CurrentUrl extends AbstractHelper
{

    /**
     * Requête courante
     * @var Request
     */
    protected $request;

    /**
     * Constructeur de l'aide de vue CurrentUrl
     *
     * @param Request $request Requête courante
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Méthode appelée lorsqu'un script tente d'appeler cet objet comme une fonction.
     *
     * @return string Url courante
     */
    public function __invoke()
    {
        if ($this->request) {
            $url = $this->request->getUriString();
            return $url;
        }
    }
}
