<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/04/16
 * Time: 10:20
 */

namespace Aqualeha\AppBundle\Services;

use Aqualeha\AppBundle\Form\DataTransformer\DateTimeTransformer;
use DateTime;
use Aqualeha\AppBundle\Entity\Country;
use Aqualeha\AppBundle\Entity\Holiday;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class HolidayManager
 *
 * @package Aqualeha\AppBundle\Services
 */
class HolidayManager
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var null|SecurityContext
     */
    protected $security;

    /**
     * @param EntityManager     $em
     * @param SecurityContext   $security
     */
    public function __construct($em, $security = null)
    {
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * Check the date and update it if this one is a week end day or a holiday
     *
     * @param string  $day
     * @param integer $nbDay
     * @param string  $country
     *
     * @return array
     */
    public function checkDate($day, $nbDay, $country)
    {
        $dateTimeTransformer = new DateTimeTransformer();
        $dateTime = $dateTimeTransformer->reverseTransform($day);

        for ($i = 0; $i < $nbDay; $i++) {
            $dateTime->modify('+1 days');

            while ($this->isWeekEnd($dateTime) or $this->isHoliday($dateTimeTransformer->transform($dateTime), $country)) {
                $dateTime->modify('+1 days');
            }
        }

        return $dateTime;
    }

    /**
     * Function who check if the date is a week end day
     *
     * @param array $date
     *
     * @return bool
     */
    private function isWeekEnd($date)
    {
        if ($date->format('N') >= 6) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function who check if the date is a holiday
     *
     * @param string $date
     * @param string $country
     *
     * @return bool
     */
    public function isHoliday($date, $country)
    {
        $country = $this->em->getRepository('AqualehaAppBundle:Country')->findOneByName($country);
        $holiday = $this->em->getRepository('AqualehaAppBundle:Holiday')->findBy(
            array(
                'date'    => $date,
                'country' => $country->getId()
            )
        );

        if (count($holiday) == 0) {
            return false;
        } else {
            return true;
        }
    }
}