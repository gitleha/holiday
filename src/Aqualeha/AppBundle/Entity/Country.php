<?php

namespace Aqualeha\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Aqualeha\AppBundle\Entity;

/**
 * Aqualeha\AppBundle\Entity\Country
 *
 * @ORM\Table(name="t_country")
 * @ORM\Entity
 * @package Aqualeha\AppBundle\Entity
 */
class Country
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Holiday", mappedBy="holiday")
     */
    private $holidays;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $holidays
     */
    public function setHolidays($holidays)
    {
        $this->holidays = $holidays;
    }

    /**
     * @return mixed
     */
    public function getHolidays()
    {
        return $this->holidays;
    }

    public function __construct()
    {
        $this->holidays = new ArrayCollection();
    }

    /**
     * Add holidays
     *
     * @param Holiday $holidays
     */
    public function addHoliday(Holiday $holidays)
    {
        $this->holidays[] = $holidays;
    }
}