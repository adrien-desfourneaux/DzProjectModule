<?php
/**
 * Test application configuration file.
 *
 */
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Application',
        'DzProject'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            __DIR__ . '/../../../module',
            __DIR__ . '/../../../vendor'
        )
    ),
);
