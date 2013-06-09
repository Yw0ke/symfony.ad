<?php

namespace ad\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class attributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    	/*$data = $options["data"];
    	$att = $data->getAttribute();
    	
    	
    	foreach($att as $attribut)
    	{
    		$attribut->getName();
    	}*/
    	
    	//var_dump($options);
    	//die;
    	$builder->add('name', 'text', array('label' => 'null'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ad\ClassifiedBundle\Entity\attribute',
        	'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'ad_classifiedbundle_attributetype';
    }
}
