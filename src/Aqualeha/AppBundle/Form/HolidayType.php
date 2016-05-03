<?php

namespace Aqualeha\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class HolidayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', FileType::class, array('label' => 'Importer un calendrier (ICS file)'))
        ;
    }

    public function getName()
    {
        return 'aqualeha_appbundle_holidaytype';
    }
}
