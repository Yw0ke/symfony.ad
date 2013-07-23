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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
    	
        $builder
            ->add('title', 'text', array('label' => 'Titre de l\'annonce :'))
            ->add('categoryId', null, array('label' => 'Choisir une catégorie :'))
            ->add('pic', 'file', array( 'label' => 'Image de couverture :'))
        	->add('pic1', 'file', array( 'label' => 'Image optionnel :',
        								 'required' => false))
        	->add('pic2', 'file', array( 'label' => 'Image optionnel :',
        								 'required' => false))
        	->add('pic3', 'file', array( 'label' => 'Image optionnel :',
        								 'required' => false));
            
            $atts = $options['data']->getAttribute();
            
            foreach ( $atts as $attribute => $value )
            {
            	if ($value['type']->getName() == 'choice')
            	{
            		$choice = array('choices' => array( 'pro'   => 'Professionnel',
					            				        'parti' => 'Particulier'
						            			       ),
            						'multiple' => false,
            						'expanded' => true);
            		
            		$builder->add($attribute, $value['type']->getName(), array('mapped' => false,
            															       'label' => $value['label'],
												            				   'choices' => array( 'Professionnel'   => 'Professionnel',
												            						               'Particulier' => 'Particulier'
												            				                      ),
												            				   'multiple' => false,
												            				   'expanded' => true
            																   
            			
            			));
            	}
            	else 
            	{
            		$builder->add($attribute, $value['type']->getName(), array('mapped' => false,
            																   'label' => $value['label'],
            		));
            	}
            	
            	
            }
            
            $builder->add('Confirmed', 'hidden', array("mapped" => false))
            
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
