<?php

namespace Aqualeha\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CountryType
 *
 * @package Aqualeha\AppBundle\Form
 */
class CountryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aqualeha_appbundle_countrytype';
    }
}
