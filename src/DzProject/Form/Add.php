<?php

/**
 * Fichier de source du Formulaire d'Ajout de Projet (Add)
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Form/Add.php
 */

namespace DzProject\Form;

use Zend\Form\Form;

/**
 * Classe formulaire d'Ajout de Projet (Add)
 *
 * @category Source
 * @package  DzProject\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Form/Add.php
 */
class Add extends Form
{
    /**
     * Constructeur du formulaire
     *
     * @param string|null $name Nom de l'élément
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(
            array(
                'name' => 'displayName',
                'options' => array(
                    'label' => 'Désignation',
                ),
                'attributes' => array(
                    'type' => 'text'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'beginDate',
                'options' => array(
                    'label' => 'Date de début',
                ),
                'attributes' => array(
                    'type' => 'date'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'endDate',
                'options' => array(
                    'label' => 'Date de fin',
                ),
                'attributes' => array(
                    'type' => 'date'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'add',
                'options' => array(
                    'label' => 'Ajouter',
                ),
                'attributes' => array(
                    'type' => 'submit'
                ),
            )
        );
    }
}
