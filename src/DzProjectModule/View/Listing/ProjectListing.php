<?php

/**
 * Fichier de source du ProjectListing.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\View\Listing
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\View\Listing;

use DzBaseModule\View\Listing\EntityListing;

/**
 * Listing des projets.
 *
 * @category Source
 * @package  DzProjectModule\View\Listing
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class ProjectListing extends EntityListing
{
    /**
     * {@inheritdoc}
     */
    const ENTITIES_LABEL = 'projects';

    /**
     * Initialisation du listing des projets.
     *
     * @return void
     */
    public function init()
    {
        $this->__init('pre');

        $projects = $this->getProjects();

    	$fields    = $this->getFields();
    	$fields[0] = new Field('Désignation');
    	$fields[1] = new Field('Période');

        foreach ($projects as $project) {
        	$id        = $project['project_id'];
        	$name      = $project['display_name'];
        	$beginDate = $project['begin_date'];
        	$endDate   = $project['end_date'];
        	$period    = $beginDate . ' - ' . $endDate;

            $fields[0]->values[$id] = $name;
            $fields[1]->values[$id] = $period;
        }

        $this->setFields($fields);

        $this->__init('post');
    }
}