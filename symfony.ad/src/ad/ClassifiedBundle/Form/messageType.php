<?php

namespace ad\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class messageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('senderName')
            ->add('senderEmail')
            ->add('object')
            ->add('message')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ad\ClassifiedBundle\Entity\message'
        ));
    }

    public function getName()
    {
        return 'ad_classifiedbundle_messagetype';
    }
}
