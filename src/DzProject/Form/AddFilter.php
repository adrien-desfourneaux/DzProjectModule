<?php

/**
 * Fichier de source du Filtre du formulaire d'Ajout de Projet (Add)
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Form/AddFilter.php
 */

namespace DzProject\Form;

use Zend\InputFilter\InputFilter;

/**
 * Classe filtre du formulaire d'Ajout de Projet
 *
 * @category Source
 * @package  DzProject\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Form/AddFilter.php
 */
class AddFilter extends InputFilter
{
    /**
     * Constructeur du filtre
     */
    public function __construct()
    {
        $this->add(
            array(
                'name'       => 'displayName',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 200,
                        ),
                    ),
                ),
            )
        );

        /**
         * @todo
         */
        $this->add(
            array(
                'name'       => 'beginDate',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
            )
        );

        /**
         * @todo
         */
        $this->add(
            array(
                'name'       => 'endDate',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
            )
        );

        //$this->getEventManager()->trigger('init', $this);
    }
}
