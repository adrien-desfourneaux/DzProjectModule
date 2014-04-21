<?php

/**
 * Fichier de source du Filtre du formulaire d'Ajout de Projet.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\InputFilter
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\InputFilter;

use DzMessageModule\InputFilter\InputFilter;

/**
 * Classe filtre du formulaire d'Ajout de Projet
 *
 * @category Source
 * @package  DzProjectModule\InputFilter
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class AddInputFilter extends InputFilter
{
    /**
     * Initialisation du filtre.
     *
     * @return void
     */
    public function init()
    {
        $falseFormatMessage = $this->message('date false format')->setFormat('jj/mm/aaaa', ', doit être ');

        $displayNameEmpty       = $this->message('display name empty')->getContent();
        $displayNameTooLong     = $this->message('display name too long')->getContent();
        $beginDateEmpty         = $this->message('begin date empty')->getContent();
        $beginDateFalseFormat   = $falseFormatMessage->getContent();
        $beginDateInvalidFormat = $falseFormatMessage->getContent();
        $endDateEmpty           = $this->message('end date empty')->getContent();
        $endDateFalseFormat     = $falseFormatMessage->getContent();
        $endDateInvalidFormat   = $falseFormatMessage->getContent();

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
                                \Zend\Validator\NotEmpty::IS_EMPTY => $displayNameEmpty,
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 200,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_LONG => $displayNameTooLong,
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
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => $beginDateEmpty,
                            ),
                        ),
                    ),
                    array(
                        'name'=>'Date',
                        'break_chain_on_failure'=>true,
                        'options'=>array(
                            'format'=>'d/m/Y',
                            'messages'=>array(
                                'dateFalseFormat' => $beginDateFalseFormat,
                                'dateInvalidDate' => $beginDateInvalidFormat,
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
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => $endDateEmpty,
                            ),
                        ),
                    ),
                    array(
                        'name'=>'Date',
                        'break_chain_on_failure'=>true,
                        'options'=>array(
                            'format'=>'d/m/Y',
                            'messages'=>array(
                                'dateFalseFormat' => $endDateFalseFormat,
                                'dateInvalidDate' => $endDateInvalidFormat,
                            ),
                        ),
                    ),
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                    \Zend\Validator\Callback::INVALID_VALUE => 'La date de fin doit être postérieure à la date de début',
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
