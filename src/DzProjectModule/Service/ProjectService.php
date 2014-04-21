<?php

/**
 * Fichier de source pour le ProjectService
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Service;

use DzServiceModule\Service\DoctrineEntityService;

use DzProjectModule\Entity\ProjectInterface;
use DzProjectModule\Form\AddForm;
use DzProjectModule\Options\ProjectServiceOptionsInterface;

/**
 * Service pour les projets.
 *
 * @category Source
 * @package  DzProjectModule\Service
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://github.com/dieze/DzProjectModule
 */
class ProjectService extends DoctrineEntityService
{
    /**
     * Formulaire d'ajout de projet
     *
     * @var AddForm
     */
    protected $addForm;

    /**
     * Ajoute un projet depuis les données du formulaire
     *
     * @param array $data Données du formulaire
     *
     * @return false|ProjectInterface
     */
    public function add(array $data)
    {
        $entityClass = $this->getEntityClass();
        $project     = new $entityClass;
        $form        = $this->getAddForm();
        $mapper      = $this->getMapper();
        $events      = $this->getEventManager();

        // On va tenter de faire correspondre le formulaire
        // remplit par l'utilisateur et les validators

        $form->bind($project);
        $form->setData($data);

        // On retourne false si le formulaire remplit
        // est invalide
        if (!$form->isValid()) {
            return false;
        }

        /* @var $project \DzProjectModule\Entity\ProjectInterface */

        // On lance l'événement add pour que la personne qui utiliserait
        // le module puisse valider ses propres champs en implémentant le
        // Design Pattern Observateur
        $events->trigger(__FUNCTION__, $this,
            array(
                'project' => $project,
                'form' => $form
            )
        );

        $mapper->insert($project);
        $project = $form->getData();

        $events->trigger(__FUNCTION__.'.post', $this,
            array(
                'project' => $project,
                'form' => $form
            )
        );

        return $project;
    }

    /**
     * Supprime un projet
     *
     * @param integer $projectId Identifiant du projet à supprimer
     *
     * @return boolean
     */
    public function delete($projectId)
    {
        $mapper = $this->getMapper();

        // Le service récupère le projet
        // auprès du mapper. Il faut vérifier
        // si le projet existe (s'il n'est pas null)
        $project = $mapper->findById($projectId);

        // Si le projet n'a pas été trouvé
        // on renvoie false
        if (!$project) {
            return false;
        }

        // Suppression du projet
        $mapper->delete($project);

        return true;
    }

    /**
     * Obtient le formulaire d'ajout de projet.
     *
     * @return AddForm
     */
    public function getAddForm()
    {
        return $this->addForm;
    }

    /**
     * Définit le formulaire d'ajout de projet.
     *
     * @param AddForm $addForm Nouveau formulaire d'ajout de projet
     *
     * @return ProjectService
     */
    public function setAddForm(AddForm $addForm)
    {
        $this->addForm = $addForm;
        return $this;
    }
}
