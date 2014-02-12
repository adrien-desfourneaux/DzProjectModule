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
    ProjectServiceOptionsInterface
{
    /**
     * Utiliser le paramètre redirect s'il est présent
     *
     * @var bool
     */
    protected $useRedirectParameterIfPresent = true;

    /**
     * Nom de la classe d'entité projet
     *
     * @var string
     */
    protected $projectEntityClass = 'DzProject\Entity\Project';

    /**
     * Template de vue pour le widget d'affichage de plusieurs projets
     *
     * @var string
     */
    protected $projectShowallWidgetViewTemplate = 'dz-project/project/showallWidget.phtml';

    /**
     * Template de vue pour le widget d'affichage du formualire d'ajout de projet
     *
     * @var string
     */
    protected $projectAddWidgetViewTemplate = 'dz-project/project/addWidget.phtml';

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
     * Définit le template de vue pour le widget d'affichage de plusieurs projets
     *
     * @param string $projectShowallWidgetViewTemplate Chemin vers le template
     *
     * @return ModuleOptions
     */
    public function setProjectShowallWidgetViewTemplate($projectShowallWidgetViewTemplate)
    {
        $this->projectShowallWidgetViewTemplate = $projectShowallWidgetViewTemplate;
        return $this;
    }

    /**
     * Obtient le template de vue pour le widget d'affichage de plusieurs projets
     *
     * @return string
     */
    public function getProjectShowallWidgetViewTemplate()
    {
        return $this->projectShowallWidgetViewTemplate;
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
}
