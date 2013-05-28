<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\attribute;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadAttributeData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getEntityManager();
		
		$attributes = array('Price', 'Confirmed', 'OwnerType', 'OwnerAdress', 'OwnerCity', 'OwnerZip', 
							'OwnerPhone', 'Comment');
		
		foreach ($attributes as $at)
		{
			$att = new attribute();
			$att->setName($at);
			
			$manager->persist($att);
			$manager->flush();
		}
	}
	
	public function getOrder()
	{
		return 3;
	}
	
}