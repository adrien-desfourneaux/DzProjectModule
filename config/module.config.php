<?php

/**
 * Configuration du module DzProjectModule
 *
 * PHP version 5.3.3
 *
 * @category Config
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/config/module.config.php
 */

/**
 * Utiliser différentes base de données selon l'environnement (development ou test)
 */
if (defined('DZPROJECT_ENV') && DZPROJECT_ENV == 'test') {
    $db_path = __DIR__ . '/../tests/_data/dzproject.sqlite';
} else {
    $db_path = __DIR__ . '/../data/dzproject.sqlite';
}

return array(
    'view_manager' => array(
        // Le module doit traiter les erreurs
        // afin d'être utilisé seul en développement et test.
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'dzproject' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'dzproject' => 'DzProjectModule\Controller\ProjectController',
        ),
    ),
    'router' => array(
        'routes' => array(

            // Information du module
            'dzproject' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/project[/]',
                    'defaults' => array(
                        'controller' => 'dzproject',
                        'action' => 'index',
                    ),
                ),

                'may_terminate' => 'true',
                'child_routes' => array(

                    // Affichage des erreurs
                    'error' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'error',
                            'defaults' => array(
                                'controller' => 'dzproject',
                                'action' => 'error',
                            ),
                        ),
                    ),

                    // Listing des projets
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'list[/:type][/]',
                            'constraints' => array(
                                'type' => '(all)|(active)',
                            ),
                            'defaults' => array(
                                'action' => 'list',
                                'type' => 'all',
                            ),
                        ),
                    ),

                    // Ajout d'un projet
                    'add' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'add[/]',
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),

                    // Suppression d'un projet
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'delete/:id[/]',
                            /*'contraints' => array(
                                'id' => '\d',
                            ),*/
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'dzproject_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/DzProjectModule/Entity'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'DzProjectModule\Entity' => 'dzproject_entity'
                )
            )
        ),
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'user' => '',
                    'password' => '',
                    'path' => $db_path,
                )
            )
        )
    ),
    'dzproject' => array(
        'project_list_has_add_action' => true,
        'project_list_has_delete_action' => true,
    )
);
