<?php

namespace Aqualeha\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }

    public function getName()
    {
        return 'aqualeha_appbundle_countrytype';
    }
}
