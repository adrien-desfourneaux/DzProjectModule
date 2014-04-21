<?php

/**
 * Fichier de source du DeleteViewModel.
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

use DzProjectModule\Service\ProjectService;

/**
 * Classe AddViewModel.
 * Vue-Modèle pour l'ajout de projet
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Model
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class DeleteViewModel extends ViewModel
{
    /**
     * {@inheritdoc}
     */
    protected $template = 'dz-project-module/project/delete.phtml';

    /**
     * {@inheritdoc}
     */
    protected $defaults = array(
        'id'        => false,
        'hasTitle'  => true,
        'hasSubmit' => true,
        'redirect'  => false,
        'isWidget'  => false,
    );

    /**
     * {@inheritdoc}
     */
    protected $assets = array(
        'head' => array(
            'css' => array(
                '/dzproject/vendor/bootstrap/dist/css/bootstrap.css',
                '/dzproject/css/dzproject.css',
            ),
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Exceptions
        $messagePlugin          = $this->plugin('message');
        $messageExceptionPlugin = $this->plugin('messageException');

        // Le controller est censé envoyer l'id.
        $id = $this->getVariable('id');
        
        $service = $this->getService();
        $project = $service->findById($id);

        if (!$project) {
            $message = $messagePlugin('project not found');
            throw $messageExceptionPlugin($message);
        }

        $this->setVariable('project', $project);
    }

    /**
     * Effectue le rendu de la balise d'ouverture du
     * formulaire de suppression de projet.
     *
     * @return string
     */
    public function renderFormOpenTag()
    {
        $urlHelper = $this->helper('url');

        $id     = $this->getVariable('id');
        $route  = 'dzproject/delete';
        $method = 'post';
        $action = $urlHelper($route, array('id' => $id));

        return '<form method="' . $method . '" action="' . $action . '">';
    }

    /**
     * Effectue le rendu du champ caché de 
     * redirection en cas de succés de la suppression.
     *
     * @param string $redirect Url de redirection.
     *
     * @return string
     */
    public function renderRedirect($redirect = null)
    {
        $escapeHtml = $this->helper('escapeHtml');

        // Valeur fournie non null
        if ($redirect) {
            $this->redirect = $redirect;
        }

        // Stockage en variable
        $redirect = $this->redirect;

        // Redirect === false ?
        if (!$redirect) {
            return '';
        }

        // EscapeHtml
        $redirect = $escapeHtml($redirect);

        ob_start();
        ?>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <?php
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Effectue le rendu du bouton
     * de validation du formulaire.
     *
     * @return string
     */
    public function renderSubmit()
    {
        if ($this->hasSubmit) {
            ob_start();
            ?>
            <input type="submit" name="submit" value="Supprimer" class="btn btn-danger"/>
            <?php
            $content = ob_get_clean();

            return $content;
        } else {
            return '';
        }
    }

    /**
     * Obtient le service de gestion des projets.
     *
     * @return ProjectService
     */
    public function getService()
    {
        $servicePlugin = $this->plugin('service');
        $service = $servicePlugin('DzProjectModule\ProjectService');

        return $service;
    }
}