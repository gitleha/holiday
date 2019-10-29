<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/04/16
 * Time: 10:20
 */

namespace Aqualeha\AppBundle\Services;

use Aqualeha\AppBundle\Form\DataTransformer\DateTimeTransformer;
use Aqualeha\AppBundle\Repository\HolidayRepository;
use Doctrine\ORM\EntityManager;

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
     * @param EntityManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Check the date and update it if this one is a week end day or a holiday
     *
     * @param string $day
     * @param integer $nbDay
     * @param string $country
     * @param string $operator
     *
     * @return \DateTime
     */
    public function checkDate($day, $nbDay, $country, $operator = '+')
    {
        $allowedOperators = array('-', '+');

        if (!in_array($operator, $allowedOperators)) {
            $operator = '+';
        }

        $dateTimeTransformer = new DateTimeTransformer();
        $dateTime = $dateTimeTransformer->reverseTransform($day);

        for ($i = 0; $i < $nbDay; $i++) {
            $dateTime->modify($operator . '1 days');

            while ($this->isWeekEnd($dateTime) or $this->isHoliday($dateTimeTransformer->transform($dateTime), $country)) {
                $dateTime->modify($operator . '1 days');
            }
        }

        if (($this->isWeekEnd($dateTime) or $this->isHoliday($dateTimeTransformer->transform($dateTime), $country)) && $nbDay == 0) {
            while ($this->isWeekEnd($dateTime) or $this->isHoliday($dateTimeTransformer->transform($dateTime), $country)) {
                $dateTime->modify($operator . '1 days');
            }
        }

        return $dateTime;
    }

    /**
     * Function who check if the date is a week end day
     *
     * @param \DateTime $date
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
                'date' => $date,
                'country' => $country->getId()
            )
        );

        if (count($holiday) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getHolidayOfYear($year)
    {
        /** @var HolidayRepository $holidayRepository */
        $holidayRepository = $this->em->getRepository('AqualehaAppBundle:Holiday');

        return $holidayRepository->findByYear($year);
    }
}