<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\attributeValues;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadAttributeValuesData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getManager();
		
		//Requete pour récuperer les Ads
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('a');
		$qb->from('adClassifiedBundle:Ads','a');
		$ads = $qb->getQuery()->getResult();
		
		//Requete pour avoir les attributs
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('a');
		$qb->from('adClassifiedBundle:attribute','a');
		$att = $qb->getQuery()->getResult();
		
		$values = array('Valeur 1', 'Valeur 2', 'Valeur 3', 'Valeur 4', 'Valeur 5', 'Valeur 6', 'Valeur 7', 'Valeur 8');
		
		foreach ($ads as $ad)
		{
			foreach($att as $attribute)
			{
				$attVal = new attributeValues();
				
				$attVal->setAttributeId($attribute);
				$attVal->setAdsId($ad);
				
				if ($attribute->getName() == 'Confirmed')	//Valeur 1 non confirmer, Valeur 2 confirmer par l'admin.
				{
					$attVal->setValue(mt_rand(0, 1));
				}
				else
				{
					$attVal->setValue($values[mt_rand(0, 7)]);
				}
				
				$manager->persist($attVal);
				$manager->flush();
			}
		}
	}
	
	public function getOrder()
	{
		return 4;
	}
}