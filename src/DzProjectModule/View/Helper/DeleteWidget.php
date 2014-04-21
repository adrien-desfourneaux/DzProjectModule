<?php

/**
 * Fichier de source du DeleteWidget
 * Widget qui affiche le formulaire de suppression de projet
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\View\Helper;

use DzProjectModule\Service\ProjectService;

use DzViewModule\View\Helper\Widget;

/**
 * Widget d'affichage du formulaire de suppression de projet
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class DeleteWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    protected $validOptions = array(
        'id',
        'hasTitle',
        'hasSubmit',
        'redirect',
        'render'
    );
}
