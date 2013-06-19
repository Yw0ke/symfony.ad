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
		$manager = $this->container->get('doctrine')->getManager();
		
		$IntAttributes = array('Price', 'Confirmed', 'OwnerZip', 'OwnerPhone');
		$StrAttributes = array('OwnerType', 'OwnerAdress', 'OwnerCity', 'Comment');
		
		
		foreach ($IntAttributes as $at)
		{
			$att = new attribute();
			$att->setName($at);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :integer');
			$qb->setParameter(':integer', 'integer');
			
			$type = $qb->getQuery()->getResult();			
			
			$att->setTypeId($type[0]);
			
			$manager->persist($att);
			$manager->flush();
		}
		
		foreach ($StrAttributes as $at)
		{
			$att = new attribute();
			$att->setName($at);
				
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :string');
			$qb->setParameter(':string', 'string');
				
			$type = $qb->getQuery()->getResult();
				
			$att->setTypeId($type[0]);
				
			$manager->persist($att);
			$manager->flush();
		}
	}
	
	public function getOrder()
	{
		return 4;
	}
	
}