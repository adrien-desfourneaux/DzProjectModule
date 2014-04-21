<?php

/**
 * Fichier de source du AddWidget
 * Widget qui affiche le formulaire d'Ajout de projet
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

use DzProjectModule\View\Model\AddViewModel;

use DzViewModule\View\Helper\Widget;

/**
 * Widget d'affichage du formulaire d'ajout de projet.
 *
 * @category Source
 * @package  DzProjectModule\View\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    protected $validOptions = array(
        'hasTitle',
        'hasSubmit',
        'redirectSuccess',
        'redirectFailure',
    );
}