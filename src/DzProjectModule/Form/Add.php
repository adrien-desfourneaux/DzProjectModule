<?php

/**
 * Fichier de source du Formulaire d'Ajout de Projet (Add)
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Form/Add.php
 */

namespace DzProjectModule\Form;

use Zend\Form\Form;
use Zend\Session\Container as SessionContainer;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Classe formulaire d'Ajout de Projet (Add)
 *
 * @category Source
 * @package  DzProjectModule\Form
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Form/Add.php
 */
class Add extends Form
{

    /**
     * Conteneur de session pour le AddForm
     *
     * @var Container
     */
    protected $sessionContainer;

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

    /**
     * Sauvegarde les données du AddForm
     * dans la session.
     *
     * @return Add
     */
    public function saveData()
    {
        $container = $this->getSessionContainer();

        // Ne rien enregistrer si le formulaire n'a pas été validé
        if (!$this->hasValidated()) {
            return;
        } else {
            $container->addFormData = $this->getData();
        }
        
        return $this;
    }

    /**
     * Récupère les données du AddForm
     * depuis la session et les définit pour le AddForm.
     * hydrate: array() -> $object
     *
     * @param boolean $flush Supprime les messages de la session si vaut true
     *
     * @return Add
     */
    public function retrieveData($flush = true)
    {
        $container = $this->getSessionContainer();
        $data = $container->addFormData;
        $hydrator = $this->getHydrator();

        if ($data) {

            // setData() attend un paramètre de type array()
            // S'il n'est pas déjà un array(), alors on l'extrait
            // dans un array() via un hydrateur.

            if (!is_array($data)) {

                // $data instanceof \DzProjectModule\Entity\ProjectInterface

                $data = $hydrator->extract($data);
            }

            $this->setData($data);
            if ($flush) {
                unset($container->addFormData);
            }
        }

        return $this;
    }

    /**
     * Sauvegarde les messages du AddForm
     * dans la session.
     *
     * @param boolean $force Si true, écrase les valeurs déjà présentes en session,
     *                       même si le formulaire ne contient aucun message.
     *
     * @return Add
     */
    public function saveMessages()
    {
        $container = $this->getSessionContainer();
        $messages = $this->getMessages();

        // Ne rien enregistrer si le
        // formulaire n'a pas de message
        $container->addFormMessages = $messages;
        
        return $this;
    }

    /**
     * Récupère les messages du AddForm
     * depuis la session et les définit pour le AddForm.
     *
     * @param boolean $flush Supprime les messages de la session si vaut true
     *
     * @return Add
     */
    public function retrieveMessages($flush = true)
    {
        $container = $this->getSessionContainer();
        $messages = $container->addFormMessages;

        if ($messages) {
            $this->setMessages($messages);
            if ($flush) {
                unset($container->addFormMessages);
            }
        }

        return $this;
    }

    /**
     * Définit le container de session
     *
     * @param SessionContainer $container Nouveau conteneur de session
     *
     * @return Add
     */
    public function setSessionContainer($container)
    {
        $this->sessionContainer = $container;
        
        return $this;
    }

    /**
     * Obtient le conteneur de session
     *
     * @return SessionContainer
     */
    public function getSessionContainer()
    {
        return $this->sessionContainer;
    }
}
