<?php

namespace Aqualeha\AppBundle\Controller;

use Aqualeha\AppBundle\Entity\Country;
use Aqualeha\AppBundle\Entity\Document;
use Aqualeha\AppBundle\Entity\Holiday;
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
     * @Route("/", name="aqueleha_home")
     * @Template("AqualehaAppBundle:Default:index.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        return array('name' => "aqualeha");
    }

    /**
     * Creates a new list of Holiday entity.
     *
     * @Route("/new", name="aqueleha_new")
     * @Template("AqualehaAppBundle:Default:create.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('file', FileType::class, array('label' => 'Importer un calendrier (ICS file)'))
            ->getForm();

        $form->handleRequest($request);

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

            return $this->redirect($this->generateUrl('aqueleha_home', array('id' => $holiday->getId())));
        }

        return array(
            'form'   => $form->createView()
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
     * @Route("/checkHoliday/{country}/{date}/{nbDay}", name="aqueleha_checkHolidayMore", defaults={"nbDay" = 0})
     * @Method("get")
     * @Template("AqualehaAppBundle:Default:date.html.twig")
     *
     * @param string  $country
     * @param string  $date
     * @param integer $nbDay
     *
     * @return array
     */
    public function checkHolidayMoreAction($country, $date, $nbDay)
    {
        return array(
            'date' => $this->getHolidayManager()->checkDate($date, $nbDay, $country)->getTimestamp()
        );
    }
}
