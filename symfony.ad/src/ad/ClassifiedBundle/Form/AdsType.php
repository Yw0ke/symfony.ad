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
    
    	
        $builder
            ->add('title', 'text', array('label' => 'Titre de l\'annonce :'))
            ->add('categoryId', null, array('label' => 'Choisir une catégorie :'))
            ->add('file', 'file', array('label' => 'Fichier :',
            							'data_class' => null))
        	
        	->add('attribute',  'collection')
       		
        	->add('Envoyer', 'submit');
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
