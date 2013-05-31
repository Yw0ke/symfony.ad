<?php
// src/ad/ClassifiedBundle/Form/Type/AdsParameterType.php
namespace ad\ClassifiedBundle\Form;

use ad\ClassifiedBundle\Form\AdsType;

use ad\ClassifiedBundle\Form\AdsParameter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AdsParameterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	
		$data = $options["data"]->get();
		
		var_dump($data);
		die;

        foreach ($data as $k => $value)
        {
             $builder->add($k,"text",array("label"=>$value["label"]));
        }
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'ad\ClassifiedBundle\Form\AdsParameter',
				'cascade_validation' => true,
		));
	}
	
	public function getName()
	{
		return 'task';
	}
}