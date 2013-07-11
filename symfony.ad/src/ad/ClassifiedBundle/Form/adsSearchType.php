<?php
namespace ad\ClassifiedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class adsSearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		if (isset($options['data']))
		{
			if (!is_null($options['data']['motcle']))
			{ 
				$data = $options['data']['motcle']; 
			} 
			else
			{
				$data = "nom de l'annonce";
			}
		}
		else
		{
			$data = "nom de l'annonce";
		}
		
		$builder->add('motcle', 'text', array('data' => $data ));
	}

	public function getName()
	{
		return 'adsSearch';
	}
}