<?php

namespace Aqualeha\AppBundle\Controller;

use Aqualeha\AppBundle\Entity\Country;
use Aqualeha\AppBundle\Entity\Document;
use Aqualeha\AppBundle\Entity\Holiday;
use Aqualeha\AppBundle\Form\DataTransformer\DateTimeTransformer;
use Aqualeha\AppBundle\Services\HolidayManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DefaultController
 *
 * @package Aqualeha\AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="aqualeha_home")
     * @Template("AqualehaAppBundle:Default:index.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        return array('name' => 'aqualeha');
    }

    /**
     * Creates a new list of Holiday entity.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/new", name="aqualeha_new")
     * @Template("AqualehaAppBundle:Default:create.html.twig")
     */
    public function newAction(Request $request)
    {
        $document = new Document();

        $form = $this->createFormBuilder($document)->add('file', 'Symfony\Component\Form\Extension\Core\Type\FileType', array('label' => 'Import a calendrier (ICS file) -> '))->getForm();
        $form->handleRequest($request);

        $data = $this->getDoctrine()->getRepository('AqualehaAppBundle:Country')->findAll();

        //if the form is valid and le file type is calendar otherwise send a form
        if ($form->isValid() and $document->getFile()->getMimeType()=="text/calendar") {
            $em = $this->getDoctrine()->getEntityManager();

            //new instance of the calfileparser
            $cal = $this->container->get('aqualeha.app.calfileparser');

            //parse ics type to json
            $data = $cal->parse($document->getFile()->getPathName(), "json");

            //parse json type to array
            $data = json_decode($data, true);

            //If we don't know the country, we add it
            //Otherwise we continue
            $countries = $this->getDoctrine()->getRepository('AqualehaAppBundle:Country')->findOneByName(substr($document->getFile()->getClientOriginalName(), 0, strpos($document->getFile()->getClientOriginalName(), '.')));
            if (count($countries) == 0) {
                $country = new Country();
                $country->setName(substr($document->getFile()->getClientOriginalName(), 0, strpos($document->getFile()->getClientOriginalName(), '.')));
                $em->persist($country);
            } else {
                $country = $countries;
            }

            //for each day in the array, we add a new holiday
            foreach ($data as $day) {
                $holiday = new Holiday();
                $holiday->setName($day['summary']);
                $holiday->setDate($day['dtstart;value=date']);
                $holiday->setCountry($country);
                $em->persist($holiday);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('aqualeha_new'));
        }

        return array(
            'form'      => $form->createView(),
            'countries' => $data
        );
    }

    /**
     * @return \Aqualeha\AppBundle\Services\HolidayManager
     */
    private function getHolidayManager()
    {
        return $this->container->get('aqualeha.app.holidaymanager');
    }

    /**
     * Check if the day is a Holiday and give a new date.
     * We can add a number of day in addition like /checkHoliday/FRA/20160429/5 -> 20160504
     *
     * @param string  $country
     * @param string  $date
     * @param integer $nbDay
     *
     * @return array
     *
     * @Route("/checkHoliday/{country}/{date}/{nbDay}", name="aqualeha_checkHolidayMore", defaults={"nbDay" = 0})
     * @Method("get")
     * @Template("AqualehaAppBundle:Default:date.html.twig")
     */
    public function checkHolidayAction($country, $date, $nbDay)
    {
        return array(
            'date' => $this->getHolidayManager()->checkDate($date, $nbDay, $country)->getTimestamp()
        );
    }

    /**
     * Check if the day is a Holiday and return a boolean.
     * We can add a number of day in addition like /isHoliday/FRA/20160429/6 -> 1 (true)
     *
     * @param string  $country
     * @param string  $date
     * @param integer $nbDay
     *
     * @return array
     *
     * @Route("/isHoliday/{country}/{date}/{nbDay}", name="aqualeha_isHoliday", defaults={"nbDay" = 0})
     * @Method("get")
     * @Template("AqualehaAppBundle:Default:date.html.twig")
     */
    public function isHolidayAction($country, $date, $nbDay)
    {
        $dateTimeTransformer = new DateTimeTransformer();
        $dateTime = $dateTimeTransformer->reverseTransform($date);
        $dateTime->modify('+'.$nbDay.' days');

        return array(
            'date' => $this->getHolidayManager()->isHoliday($dateTimeTransformer->transform($dateTime), $country)
        );
    }
}
