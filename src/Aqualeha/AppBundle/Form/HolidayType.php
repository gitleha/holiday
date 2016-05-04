<?php

namespace Aqualeha\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HolidayType
 * @package Aqualeha\AppBundle\Form
 */
class HolidayType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', FileType::class)
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aqualeha_appbundle_holidaytype';
    }
}
