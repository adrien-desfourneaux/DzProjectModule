<?php

/**
 * Plugin de Contrôleur DzProjectError
 * Affiche la page d'erreur avec un message personnalisé
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProjectModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Controller/Plugin/DzProjectError.php
 */

namespace DzProjectModule\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Plugin de Contrôleur DzProjectError
 * Affiche la page d'erreur avec un message personnalisé
 *
 * @category Source
 * @package  DzProjectModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProjectModule/blob/master/src/DzProjectModule/Controller/Plugin/DzProjectError.php
 */
class DzProjectError extends AbstractPlugin
{
      /**
       * Retourne la page d'erreur du module DzProjectModule
       * en y intégrant un message d'erreur personnalisé
       *
       * @param string $errorMessage Message d'erreur
       *
       * @return mixed
       */
      public function __invoke($errorMessage)
      {
            $controller = $this->getController();
            $request = $controller->getRequest();
            $serviceLocator = $controller->getServiceLocator();

            // On fournit un paramètre POST contenant le message d'erreur à afficher
            $request->getPost()->set('errorMessage', $errorMessage);

            // On dispatche le controller "dzproject" avec l'action "error"
            // on récupère son ViewModel et on définit la variable errorMessage
            $viewModel = $controller->forward()->dispatch('dzproject', array('action' => 'error'));
            $viewModel->setVariable('errorMessage', $errorMessage);

            return $viewModel;
      }     
}