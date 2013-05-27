<?php

namespace ad\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('price')
            ->add('confirmed')
            ->add('ownerType')
            ->add('ownerAdress')
            ->add('ownerCity')
            ->add('ownerZip')
            ->add('ownerCountry')
            ->add('ownerPhone')
            ->add('comment')
            ->add('boatId')
            ->add('file')
            ->add('categoryId')
            ->add('userId')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ad\ClassifiedBundle\Entity\Ads'
        ));
    }

    public function getName()
    {
        return 'ad_classifiedbundle_adstype';
    }
}
