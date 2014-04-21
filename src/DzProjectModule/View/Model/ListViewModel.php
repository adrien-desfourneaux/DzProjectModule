<?php

/**
 * Fichier de source du ListViewModel.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\View\Model;

use DzViewModule\View\Model\ViewModel;

use DzProjectModule\Form\AddForm;
use DzProjectModule\Service\ProjectService;
use DzProjectModule\View\Listing\ProjectListing;

/**
 * Classe ListViewModel.
 * Vue-Modèle pour le listing de projets.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ListViewModel extends ViewModel
{
    /**
     * {@inheritdoc}
     */
    protected $template = 'dz-project-module/project/list.phtml';

    /**
     * {@inheritdoc}
     */
    protected $defaults = array(
        'type'            => 'all',
        'hasTitle'        => true,
        'hasAddAction'    => true,
        'hasDeleteAction' => true,
        'isWidget'        => false,
    );

    /**
     * {@inheritdoc}
     */
    protected $assets = array(
        'head' => array(
            'css' => array(
                '/dzproject/css/dzproject.css',
                '/dzproject/vendor/bootstrap/dist/css/bootstrap.min.css',
            ),
            'js' => array(
                '/dzproject/vendor/jquery/dist/jquery.min.js',
                '/dzproject/vendor/bootstrap/dist/js/bootstrap.min.js'
            ),
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $messagePlugin          = $this->plugin('message');
        $messageExceptionPlugin = $this->plugin('messageException');

        $type     = $this->getVariable('type');
        
        $service  = $this->getService();
        $projects = $service->findByType($type);

        // Si aucun projet dans la base de données
        // on affiche un listing vide des projets
        if (!$projects) {
            $projects = array();
        }

        $listing = new ProjectListing();
        $listing->setProjects($projects);
        $listing->init();

        $fields   = $listing->getFields();
        $projects = $listing->getProjects();
        $addForm  = $this->getAddForm();

        $this->setVariable('projects', $projects);
        $this->setVariable('fields', $fields);
        $this->setVariable('addForm', $addForm);
    }

    /**
     * Rendu du script d'ouverture auto de la fenêtre
     * d'ajout de projet.
     *
     * S'il y a des erreurs dans le formulaire d'ajout de
     * projet on ouvre automatiquement la fenêtre d'ajout
     * de projet.
     *
     * @return void
     */
    public function renderAddWindowJs()
    {
        $inlineScript = $this->helper('inlineScript');

        $form   = $this->getVariable('addForm');
        $errors = $form->getMessages();

        if ($errors) {
            ob_start();
            $inlineScript->captureStart();
            echo "$('#addProjectModal').modal('show');";
            $inlineScript->captureEnd();
            $content = ob_get_clean();
            
            return $content;
        } else {
            return '';
        }
    }

    /**
     * Effectue le rendu du widget d'ajout de projet.
     *
     * @return string
     */
    public function renderAddWidget()
    {
        $currentUrl = $this->helper('currentUrl');
        $widget     = $this->helper('DzProjectModule\AddWidget');
        
        $url = $currentUrl(); // __invoke
    
        $content = $widget(
            array(
                'hasTitle'        => false,
                'hasSubmit'       => false,
                'redirectSuccess' => $url,
                'redirectFailure' => $url,
            )
        );

        return $content;
    }

    /**
     * Effectue le rendu des titres du listing.
     *
     * @return string
     */
    public function renderHeadings()
    {
        $hasDelete = $this->getVariable('hasDeleteAction');
        $fields    = $this->getVariable('fields');

        $return = '';

        if ($hasDelete) {
            $return .= '<th></th>';
        }

        foreach ($fields as $field) {
            $return .= '<th class="heading">' . $field->heading . '</th>';
        }
        
        return $return;
    }

    /**
     * Effectue le rendu des entrées du listing des projets.
     *
     * @return string
     */
    public function renderEntries()
    {
        $projects = $this->getVariable('projects');
        $return   = '';

        foreach ($projects as $project) {
            $return .= '<tr class="entry">';
            $return .= $this->renderEntry($project);
            $return .= '</tr>';
        }

        return $return;
    }

    /**
     * Effectue le rendu d'une entrée du listing des projets.
     *
     * @param array $project Données projet.
     *
     * @return string
     */
    public function renderEntry($project)
    {
        $id     = $project['project_id'];
        $fields = $this->getVariable('fields');
        $return = '';

        $return .= $this->renderDeleteButton($id);

        foreach ($fields as $field) {
            $class = $field->get('class',  $id, '');
            $href  = $field->get('href',   $id, '');
            $value = $field->get('values', $id, null);
            
            if ($class) {
                $class = ' class="' . $class . '"';
            }

            if ($href) {
                $href_open  = '<a href="' . $href . '" class="href">';
                $href_close = '</a>';
            } else {
                $href_open  = '';
                $href_close = '';
            }

            if ($value !== null) {
                $value = '<span class="value">' . $value . '</span>';
            } else {
                $value = '';
            }

            $return .= '<td' . $class . '>';
            $return .= $href_open;
            $return .= $value;
            $return .= $href_close;
            $return .= '</td>';
        }

        return $return;
    }

    /**
     * Effectue le rendu d'un bouton de suppression projet.
     *
     * <td><button (...)/></td>
     *
     * @param integer $id Identifiant du projet.
     *
     * @return string
     */
    public function renderDeleteButton($id)
    {
        $hasDelete = $this->getVariable('hasDeleteAction');
        $content   = '';

        if ($hasDelete) {
            ob_start();
            ?>
            <td>
                <button
                    class="btn btn-default action deleteAction"
                    data-toggle="modal"
                    data-target="#deleteProjectModal<?php echo $id; ?>">
                    <img src="/dzproject/img/trash.png" alt="Delete"/>
                </button>
            </td>
            <?php
            $content = ob_get_clean();
        }

        return $content;
    }

    /**
     * Effectue le rendu du widget de suppression d'un projet.
     *
     * @param integer $id Identifiant du projet.
     *
     * @return string
     */
    public function renderDeleteWidget($id)
    {
        $widget = $this->helper('DzProjectModule\DeleteWidget');
        
        $content = $widget(
            array(
                'id'        => $id,
                'hasTitle'  => false,
                'hasSubmit' => false,
            )
        );

        return $content;
    }

    /**
     * Obtient le service des projets.
     *
     * @return ProjectService
     */
    public function getService()
    {
        $servicePlugin = $this->plugin('service');
        $service = $servicePlugin('DzProjectModule\ProjectService');

        return $service;
    }

    /**
     * Obtient le formulaire d'ajout de projet.
     *
     * @return AddForm
     */
    public function getAddForm()
    {
        $formPlugin = $this->plugin('form');
        $form = $formPlugin('DzProjectModule\AddForm');

        return $form;
    }
}