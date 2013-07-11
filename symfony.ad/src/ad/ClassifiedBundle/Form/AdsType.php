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
            ->add('file', 'file', array('label' => 'Fichier :',
            							'data_class' => null));
            
            $atts = $options['data']->getAttribute();
            
            //var_dump($atts['OwnerType']['type']->getName());
            //die;
            
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
            
            
            
            
            
        /*$atts = $options['data']->getAttribute();
		$factory = $builder->getFormFactory();
		
		$builder->addEventListener(
		FormEvents::PRE_SET_DATA,
		function(FormEvent $event) use($atts, $factory){
			$form = $event->getForm();

			$formOptions = array(
					'data_class' => null,
					'auto_initialize' => false
			);

			// create the field, this is similar the $builder->add()
			// field name, field type, data, options
			foreach ( $atts as $attribute => $value)
			{
				$form->add($factory->createNamed($attribute, $value['type']->getName(), null, $formOptions));
			}
		}
		);*/
	        
       	
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
