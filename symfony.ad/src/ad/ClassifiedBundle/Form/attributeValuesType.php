<?php

namespace ad\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class attributeValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    	
        $builder->add('value', 'text', array('label' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ad\ClassifiedBundle\Entity\attributeValues',
        	'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'ad_classifiedbundle_attributevaluestype';
    }
}
