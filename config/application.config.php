<?php
/**
 * Fichier de configuration de l'application de test.
 *
 * Ce fichier contient uniquement les modules réellement nécéssaires
 * pour que le module fonctionne.
 *
 * Ce fichier devrait être lancé soit par /public/dzproject.php
 * ou /public/dzproject.test.php
 *
 * PHP version 5.3.3
 *
 * @category Config
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/config/application.config.php
 */
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'DzProjectModule'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            __DIR__ . '/../../../module',
            __DIR__ . '/vendor'
        )
    ),
);
