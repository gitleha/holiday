<?php
/**
 * Created by PhpStorm.
 * User: davenel
 * Date: 25/04/16
 * Time: 14:03
 */

namespace Aqualeha\AppBundle\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class IdEntitiesTransformer
 *
 * @package Leha\CommonBundle\Form\DataTransformer
 *
 * @author  Sylvain Davenel <sdavenel@aqualeha.fr>
 */
class DateTimeTransformer implements DataTransformerInterface
{
    /**
     * tranform function
     *
     * @param array $date
     *
     * @return string
     */
    public function transform($date)
    {
        if (isset($date)) {
            //Si la date n'est pas vide on la transforme en string
            $datetoString = $date->format('Ymd');
        } else {
            //Sinon on renvoie une chaine vide
            $datetoString = "";
        }

        return $datetoString;
    }

    /**
     * reverseTransform function
     *
     * @param string $chain
     *
     * @return array
     */
    public function reverseTransform($chain)
    {
        //Si la chaine contient une valeur
        if (isset($chain)) {
            //On transforme la chaine en datetime et startDateBool passe à vrai
            $date = new DateTime();
            $date->setTimestamp(strtotime($chain));
            $date->createFromFormat('d/m/Y', strtotime($chain));

            return $date;
        } else {
            return null;
        }
    }
}