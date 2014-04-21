<?php

/**
 * Configuration du module DzProjectModule.
 *
 * PHP version 5.3.0
 *
 * @category Config
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

/**
 * Utiliser différentes base de données
 * et différents préfixes d'url d'asset
 * selon l'environnement (development ou test)
 */
$db_path = '';
if (defined('DZPROJECT_ENV')) {
    if (DZPROJECT_ENV == 'test') {
        $db_path = __DIR__ . '/../tests/_data/dzproject.sqlite';
    } elseif (DZPROJECT_ENV == 'development') {
        $db_path = __DIR__ . '/../data/dzproject.sqlite';
    }
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
    'assets' => array(
        'paths' => array(
            'dzproject' => __DIR__ . '/../public',
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
                            'constraints' => array(
                                'id' => '\d+',
                            ),
                            'defaults' => array(
                                'action' => 'delete',
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
);
