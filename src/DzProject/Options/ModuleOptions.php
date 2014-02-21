<?php

/**
 * Fichier d'options pour le Module DzProject
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ModuleOptions.php
 */

namespace DzProject\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Classe d'options pour le Module DzProject
 *
 * @category Source
 * @package  DzProject\Options
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Options/ModuleOptions.php
 */
class ModuleOptions extends AbstractOptions implements
    ProjectControllerOptionsInterface,
    ProjectServiceOptionsInterface,
    ProjectWidgetsOptionsInterface,
    ProjectListOptionsInterface
{
    /**
     * Utiliser le paramètre redirect s'il est présent
     *
     * @var bool
     *
     * @see \DzProject\Options\ProjectControllerOptionsInterface
     */
    protected $useRedirectParameterIfPresent = true;

    /**
     * Nom de la classe d'entité projet
     *
     * @var string
     *
     * @see \DzProject\Options\ProjectServiceOptionsInterface
     */
    protected $projectEntityClass = 'DzProject\Entity\Project';

    /**
     * Template de vue pour le widget de listing des projets
     *
     * @var string
     *
     * @see \DzProject\Options\ProjectWidgetsOptionsInterface
     */
    protected $projectListWidgetViewTemplate = 'dz-project/project/list.phtml';

    /**
     * Template de vue pour le widget d'affichage du formualire d'ajout de projet
     *
     * @var string
     *
     * @see \DzProject\Options\ProjectWidgetsOptionsInterface
     */
    protected $projectAddWidgetViewTemplate = 'dz-project/project/add.phtml';

    /**
     * Template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @var string
     *
     * @see \DzProject\Options\ProjectWidgetsOptionsInterface
     */
    protected $projectDeleteWidgetViewTemplate = 'dz-project/project/delete.phtml';

    /**
     * Afficher ou non les actions de suppression de projet
     * dans le listing des projets
     *
     * @var bool
     *
     * @see \DzProject\Options\ProjectListOptionsInterface
     */
    protected $projectListHasDeleteAction = true;

    /**
     * Afficher ou non l'action d'ajout
     * dans le listing des projets
     *
     * @var bool
     */
    protected $projectListHasAddAction = true;

    /**
     * Définit s'il faut utiliser le paramètre redirect
     * s'il est présent
     *
     * @param bool $useRedirectParameterIfPresent Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent)
    {
        $this->useRedirectParameterIfPresent = $useRedirectParameterIfPresent;

        return $this;
    }

    /**
     * Obtient s'il faut utiliser le paramètre redirect
     * s'il est présent
     *
     * @return bool
     */
    public function getUseRedirectParameterIfPresent()
    {
        return $this->useRedirectParameterIfPresent;
    }

    /**
     * Définit le nom de la classe d'entité projet
     *
     * @param string $projectEntityClass Nom de la classe d'entité projet
     *
     * @return ModuleOptions
     */
    public function setProjectEntityClass($projectEntityClass)
    {
        $this->projectEntityClass = $projectEntityClass;

        return $this;
    }

    /**
     * Obtient le nom de la classe d'entité projet
     *
     * @return string
     */
    public function getProjectEntityClass()
    {
        return $this->projectEntityClass;
    }

    /**
     * Définit le template de vue pour le widget de listing des projets
     *
     * @param string $projectListWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectListWidgetViewTemplate($projectListWidgetViewTemplate)
    {
        $this->projectListWidgetViewTemplate = $projectListWidgetViewTemplate;

        return $this;
    }

    /**
     * Obtient le template de vue pour le widget de listing des projets
     *
     * @return string
     */
    public function getProjectListWidgetViewTemplate()
    {
        return $this->projectListWidgetViewTemplate;
    }

    /**
     * Définit le template de vue pour le widget d'affichage du formulaire d'ajout de projet
     *
     * @param string $projectAddWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectAddWidgetViewTemplate($projectAddWidgetViewTemplate)
    {
        $this->projectAddWidgetViewTemplate = $projectAddWidgetViewTemplate;

        return $this;
    }

    /**
     * Obtient le template de vue pour le widget d'affichage du formulaire d'ajout de projet
     *
     * @return string
     */
    public function getProjectAddWidgetViewTemplate()
    {
        return $this->projectAddWidgetViewTemplate;
    }

    /**
     * Définit le template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @param string $projectDeleteWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectDeleteWidgetViewTemplate($projectDeleteWidgetViewTemplate)
    {
        $this->projectDeleteWidgetViewTemplate = $projectDeleteWidgetViewTemplate;

        return $this;
    }

    /**
     * Obtient le template de vue pour le widget d'affichage du formulaire de suppression de projet
     *
     * @return string
     */
    public function getProjectDeleteWidgetViewTemplate()
    {
        return $this->projectDeleteWidgetViewTemplate;
    }

    /**
     * Définit s'il faut afficher les actions de suppression de projet
     * dans listing de projets
     *
     * @param bool $hasDeleteAction Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setProjectListHasDeleteAction($hasDeleteAction)
    {
        $this->projectListHasDeleteAction = $hasDeleteAction;

        return $this;
    }

    /**
     * Obtient s'il faut afficher les actions de suppression de projet
     * dans le listing des projets
     *
     * @return bool
     */
    public function getProjectListHasDeleteAction()
    {
        return $this->projectListHasDeleteAction;
    }

    /**
     * Définit s'il faut afficher l'action d'ajout de projet
     * dans le listing des projets
     *
     * @param bool $hasAddAction Valeur de l'option
     *
     * @return ModuleOptions
     */
    public function setProjectListHasAddAction($hasAddAction)
    {
        $this->projectListHasAddAction = $hasAddAction;

        return $this;
    }

    /**
     * Obtient s'il faut afficher l'action d'ajout de projet
     * dans le listing des projets
     *
     * @return bool
     */
    public function getProjectListHasAddAction()
    {
        return $this->projectListHasAddAction;
    }
}
