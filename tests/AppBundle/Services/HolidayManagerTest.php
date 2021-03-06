<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/04/16
 * Time: 15:42
 */

namespace Aqualeha\AppBundle\Tests\Services;

use Aqualeha\AppBundle\Services\WebTestCase;
use Aqualeha\AppBundle\Entity\Country;
use Aqualeha\AppBundle\Entity\Holiday;
use Aqualeha\AppBundle\Services\HolidayManager;
use \Phake;

/**
* Class HolydayManagerTest
*
* @package Leha\CentralBundle\Tests\Services
*/
class HolidayManagerTest extends WebTestCase {
    /**
     * @see \Aqualeha\AppBundle\Services\HolidayManager::checkDate()
     *
     * @group check
     */
    public function testCheckHolidayAction()
    {
        $country = new Country();
        $countryRepository = Phake::mock('\Doctrine\ORM\EntityRepository');
        Phake::when($countryRepository)->findOneByName(Phake::anyParameters())->thenReturn($country);

        $holiday = new Holiday();
        $holidayRepository = Phake::mock('\Doctrine\ORM\EntityRepository');
        Phake::when($holidayRepository)->findBy(array(
            'date'    => "20160504",
            'country' => $country
        ))->thenReturn(null);
        Phake::when($holidayRepository)->findBy(array(
            'date'    => "20160503",
            'country' => $country->getId()
        ))->thenReturn($holiday);
        $em = Phake::mock('\Doctrine\ORM\EntityManager');
        Phake::when($em)->getRepository('AqualehaAppBundle:Country')->thenReturn($countryRepository);
        Phake::when($em)->getRepository('AqualehaAppBundle:Holiday')->thenReturn($holidayRepository);

       // $repositoryMock = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')->getMock();
        $holidayManager = new HolidayManager($em);

        $this->assertEquals(1462485600, $holidayManager->checkDate('20160429', 4, 'FRA')->getTimestamp());
    }

    /**
     * @see \Aqualeha\AppBundle\Services\HolidayManager::isHoliday()
     *
     * @group is
     */
    public function testIsHolidayAction()
    {
        $country = new Country();
        $countryRepository = Phake::mock('\Doctrine\ORM\EntityRepository');
        Phake::when($countryRepository)->findOneByName(Phake::anyParameters())->thenReturn($country);

        $holiday = new Holiday();
        $holidayRepository = Phake::mock('\Doctrine\ORM\EntityRepository');
        Phake::when($holidayRepository)->findBy(array(
            'date'    => "20160503",
            'country' => $country
        ))->thenReturn(null);
        Phake::when($holidayRepository)->findBy(array(
            'date'    => "20160505",
            'country' => $country->getId()
        ))->thenReturn($holiday);
        $em = Phake::mock('\Doctrine\ORM\EntityManager');
        Phake::when($em)->getRepository('AqualehaAppBundle:Country')->thenReturn($countryRepository);
        Phake::when($em)->getRepository('AqualehaAppBundle:Holiday')->thenReturn($holidayRepository);

       // $repositoryMock = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')->getMock();
        $holidayManager = new HolidayManager($em);

        $this->assertEquals(1, $holidayManager->isHoliday('20160505', 'FRA'));
    }
}