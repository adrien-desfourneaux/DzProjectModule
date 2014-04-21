<?php

/**
 * Fichier de source du ListWidget
 * Widget qui affiche tous les Projets
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

use DzProjectModule\Form\AddForm;

use DzViewModule\View\Helper\Widget;

/**
 * Widget de listing des projets
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ListWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    protected $validOptions = array(
        'type',
        'hasTitle',
        'hasAddAction',
        'hasDeleteAction',
        'render'
    );
}