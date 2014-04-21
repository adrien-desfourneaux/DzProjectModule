<?php

/**
 * Aides pour les tests d'acceptation
 *
 * PHP version 5.4.0
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Helper
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link       https://github.com/dieze/DzProjectModule
 */

namespace Codeception\Module;

use Codeception\Module;

use DzProjectModule\Test\Helper\DbWebHelper;
use DzProjectModule\Test\Helper\DbWebHelperInterface;

use Zend\Dom\Query;

/**
 * Classe helper pour les tests d'acceptation.
 * Fonctions personnalisés pour le WebGuy.
 *
 * @category   Test
 * @package    DzProjectModule
 * @subpackage Helper
 * @author     Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link       https://github.com/dieze/DzProjectModule
 */
class WebHelper extends Module implements DbWebHelperInterface
{
    /**
     * Helper pour les méthodes de Db.
     *
     * @var DbWebHelper
     */
    protected $dbHelper;

    /**
     * Initialisation du Helper.
     *
     * @return void
     */
    public function _initialize()
    {
        parent::_initialize();

        $dbModule = $this->getModule('Db');
        $this->dbHelper = new DbWebHelper($dbModule);
    }

    /**
     * Exécute une requête Xpath
     *
     * @param string $xpath Requête Xpath
     *
     * @return string Résultat de la requête
     */
    public function queryXpath($xpath)
    {
    	$webdriver = $this->getModule('WebDriver');
    	$html = $webdriver->webDriver->getPageSource();

    	$dom = new Query($html);
    	$nodeList = $dom->queryXpath($xpath);

    	if (count($nodeList) > 1) {
    		return false;
    	} else {
    		return $nodeList[0]->textContent;
    	}
    }

    /**
     * {@inheritdoc}
     */
    public function haveDefaultProjectsInDatabase()
    {
        return $this->dbHelper->haveDefaultProjectsInDatabase();
    }

    /**
     * {@inheritdoc}
     */
    public function haveAllProjectDefaultsInDatabase()
    {
        return $this->dbHelper->haveAllProjectDefaultsInDatabase();
    }
}
