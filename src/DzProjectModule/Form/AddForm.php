<?php

/**
 * Fichier de source du Formulaire d'Ajout de Projet.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Form;

use DzBaseModule\Form\PersistableForm;

/**
 * Classe formulaire d'Ajout de Projet.
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddForm extends PersistableForm
{
    /**
     * Constructeur du formulaire
     *
     * @param string|null $name Nom de l'élément
     */
    public function __construct($name = null)
    {
        $this->setAttribute('role', 'form');

        parent::__construct($name);

        $this->add(
            array(
                'name' => 'displayName',
                'options' => array(
                    'label' => 'Désignation',
                ),
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'placeholder' => 'Texte 200 caractères max.',
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
                    'type' => 'date',
                    'class' => 'form-control',
                    'placeholder' => 'jj/mm/aaaa',
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
                    'type' => 'date',
                    'class' => 'form-control',
                    'placeholder' => 'jj/mm/aaaa',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'options' => array(
                    'label' => 'Ajouter',
                ),
                'attributes' => array(
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ),
            )
        );
    }
}