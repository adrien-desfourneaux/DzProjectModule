<?php

/**
 * Fichier de source du Filtre du formulaire d'Ajout de Projet (Add)
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Form/AddFilter.php
 */

namespace DzProjectModule\Form;

use Zend\InputFilter\InputFilter;

/**
 * Classe filtre du formulaire d'Ajout de Projet
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Form/AddFilter.php
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
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => "La désignation ne doit pas être vide",
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 200,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_LONG => "La désignation ne doit pas excéder 200 caractères",
                            ),
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'beginDate',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'=>'Date',
                        'break_chain_on_failure'=>true,
                        'options'=>array(
                            'format'=>'d/m/Y',
                            'messages'=>array(
                                'dateFalseFormat'=>'Format de date invalide, doit être jj/mm/aaaa',
                                'dateInvalidDate'=>'Date invalide, doit être jj/mm/aaaa'
                            ),
                        ),
                    )
                )
            )
        );

        $this->add(
            array(
                'name'       => 'endDate',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'=>'Date',
                        'break_chain_on_failure'=>true,
                        'options'=>array(
                            'format'=>'d/m/Y',
                            'messages'=>array(
                                'dateFalseFormat'=>'Format de date invalide, doit être jj/mm/aaaa',
                                'dateInvalidDate'=>'Date invalide, doit être jj/mm/aaaa'
                            ),
                        ),
                    ),
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                    \Zend\Validator\Callback::INVALID_VALUE => 'La date de fin doit être supérieure à la date de début',
                            ),
                            'callback' => function ($value, $context = array()) {
                                $beginDate = \DateTime::createFromFormat('d/m/Y', $context['beginDate']);
                                $endDate = \DateTime::createFromFormat('d/m/Y', $value);

                                return $endDate >= $beginDate;
                            },
                        ),
                    ),
                )
            )
        );

        //$this->getEventManager()->trigger('init', $this);
    }
}
