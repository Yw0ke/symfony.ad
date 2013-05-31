<?php

namespace ad\ClassifiedBundle\Form;

use ad\ClassifiedBundle\Entity\Ads;

use ad\ClassifiedBundle\Entity\attribute;
use ad\ClassifiedBundle\Form\attributeType;
use ad\ClassifiedBundle\Form\attributeValueType;
use ad\ClassifiedBundle\Entity\attributeValues;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	//$data = $options["data"];
    	
    	//var_dump($data);
    	//die;
    	//$options["data"] = $data;
    	
    	//var_dump($options);
    	//die;
		
    	
        $builder
            ->add('title')
            ->add('categoryId')
            ->add('file')
        
        	->add('attribute',  'collection', array('type' => new attributeValuesType(),
									        		'options' => array('data_class' => 'ad\ClassifiedBundle\Entity\attributeValues')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	 
    	 
    	$resolver->setDefaults(array(
    			'data_class' => 'ad\ClassifiedBundle\Entity\Ads',
    			'cascade_validation' => true,
    			
    			
    	));
    }

    public function getName()
    {
        return 'ad_classifiedbundle_adstype';
    }
}
