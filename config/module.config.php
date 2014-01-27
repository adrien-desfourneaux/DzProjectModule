<?php

/**
 * DzProject configuration
 *
 * PHP version 5.3.3
 *
 * @category Config
 * @package  DzProject
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/config/module.config.php
 */

/**
 * Use different bdd for test or development environments
 */
if (defined('DZPROJECT_ENV') && DZPROJECT_ENV == 'test') {
    $db_path = __DIR__ . '/../tests/_data/dz-project.sqlite';
} else {
    $db_path = __DIR__ . '/../data/dz-project.sqlite';
}

return array(
    'view_manager' => array(
        // The module handles errors
        // in case it is used alone
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
            'dz-project' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'dz-project' => 'DzProject\Controller\ProjectController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'dz-project_service' => 'DzProject\Service\ProjectServiceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dz-project' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    'route' => '/project[/]',
                    'defaults' => array(
                        'controller' => 'dz-project',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'showall' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'show-all[/:type][/]',
                            'constraints' => array(
                                'type' => '(all)|(active)'
                            ),
                            'defaults' => array(
                                'controller' => 'dz-project',
                                'action' => 'showall',
                                'type' => 'all'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'dz-project_model' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/DzProject/Model'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'DzProject\Model' => 'dz-project_model'
                )
            )
        ),
        'connection' => array(
            // Connection for acceptance tests
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
