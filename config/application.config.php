
<?php
/**
 * Fichier de configuration de l'application de test.
 *
 * Ce fichier contient uniquement les modules réellement nécéssaires
 * pour que le module fonctionne. Ce fichier devrait être lancé soit
 * par /public/dzproject.php ou /public/dzproject.test.php
 *
 * PHP version 5.3.0
 *
 * @category Config
 * @package  DzProjectModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

// Dossier vendor du module séparé du reste
// de l'application pour tester les dépendances
// du fichier composer.json en mode développement
// et test.
if (defined('DZPROJECT_ENV') && 
    (DZPROJECT_ENV == 'development' || DZPROJECT_ENV == 'test')
) {
    // Le vendor du module est prioritaire
    // sur le module de l'application
    if (is_dir(__DIR__ . '/../vendor')) {
        $vendor = __DIR__ . '/../vendor';
    } else {
        $vendor = __DIR__ . '/../../../vendor';
    }

} else {
    // vendor de l'application si en production
    $vendor = __DIR__ . '/../../../vendor';
}

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'DzMessageModule',
        'DzViewModule',
        'DzServiceModule',
        'DzBaseModule',
        'DzProjectModule'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            __DIR__ . '/../../../module',
            $vendor
        )
    ),
);