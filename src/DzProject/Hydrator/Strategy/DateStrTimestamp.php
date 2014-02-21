<?php

/**
 * Stratégie de conversion d'une chaine de date en timestamp
 * pour un hydrator
 *
 * PHP version 5.3.3
 *
 * @category Source
 * @package  DzProject\Hydrator\Strategy
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Hydrator/Strategy/DateStrTimestamp.php
 */

namespace DzProject\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

/**
 * Stratégie d'hydrateur de conversion d'une chaine de date en timestamp
 *
 * @category Source
 * @package  DzProject\Hydrator\Strategy
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2
 * @link     https://github.com/dieze/DzProject/blob/master/src/DzProject/Hydrator/Strategy/DateStrTimestamp.php
 */
class DateStrTimestamp extends DefaultStrategy
{
    /**
     * Format de la date
     * @var string
     */
    protected $format = 'd/m/Y';

    /**
     * Convertit la valeur donnée pour qu'elle soit extraite par l'hydrateur.
     * "Extrait la bdd"
     * extract: $object -> array()
     *
     * @param mixed $value Attend un timestamp entier.
     *
     * @return mixed Renvoie la chaine de caractère au format date.
     */
    public function extract($value)
    {
        if (is_numeric($value)) {
            $datetime = new \DateTime();
            $datetime->setTimestamp($value);
            return $datetime->format($this->format);
        }
        
        return $value;  
    }

    /**
     * Convertit la valeur donnée pour qu'elle soit
     * hydratée par l'hydrateur. Convertit une chaine
     * de caractères en timestamp si elle respecte un
     * format de date définit.
     * "Hydrate la bdd"
     * hydrate: array() -> $object
     *
     * @param mixed $value Attend une chaine de caractères au format date.
     *
     * @return mixed Le timestamp correspondant.
     */
    public function hydrate($value)
    {
        $datetime = \DateTime::createFromFormat($this->format, $value);
        if ($datetime) {
            // Utilise le format universel pour générer
            // un timestamp négatif si la date est antérieure
            // au 1er Janver 1970
            $value = $datetime->format('U');
        }

        return $value;
    }
}
