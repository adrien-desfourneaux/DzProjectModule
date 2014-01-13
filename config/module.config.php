<?php

/**
 * DzProject configuration
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @package    DzProject
 * @category   Config
 * @license    http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 */

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'dzproject' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'dzproject' => 'DzProject\Controller\ProjectController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'dzproject_service' => 'DzProject\Service\ProjectService',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dzproject' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/project',
                    'defaults' => array(
                        'controller' => 'dzproject',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'showall' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/show-all[/:type]',
                            'constraints' => array(
                                'type' => '(all)|(active)'
                            ),
                            'defaults' => array(
                                'controller' => 'dzproject',
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
            'dzproject_model' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/DzProject/Model'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'DzProject\Model' => 'dzproject_model'
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
                    'path' => __DIR__.'/../tests/_data/dzproject.sqlite',
                )
            )
        )
    ),
);
