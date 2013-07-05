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
		
		$TxtAttributes = array('OwnerType' => 'Type de vendeur', 'OwnerAdress' => 'Adresse', 'OwnerCity' => 'Ville');
		$MnyAttributes = array('Price' => 'Prix');
		$ChceAttributes = array('Confirmed' => 'Annonce confirmé ?');
		$NbrAttributes = array('OwnerZip' => 'Code postal', 'OwnerPhone' => 'Téléphone');
		$TxtareaAttributes = array('Comment' => 'Commentaire');
		
		foreach ($TxtAttributes as $at => $lab)
		{
			$att = new attribute();
			$att->setName($at);
			$att->setLabel($lab);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :text');
			$qb->setParameter(':text', 'text');
				
			$type = $qb->getQuery()->getResult();
				
			$att->setTypeId($type[0]);
				
			$manager->persist($att);
			$manager->flush();
		}
		
		foreach ($MnyAttributes as $at => $lab)
		{
			$att = new attribute();
			$att->setName($at);
			$att->setLabel($lab);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :money');
			$qb->setParameter(':money', 'money');
				
			$type = $qb->getQuery()->getResult();
				
			$att->setTypeId($type[0]);
				
			$manager->persist($att);
			$manager->flush();
		}
		
		foreach ($ChceAttributes as $at => $lab)
		{
			$att = new attribute();
			$att->setName($at);
			$att->setLabel($lab);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :choice');
			$qb->setParameter(':choice', 'choice');
			
			$type = $qb->getQuery()->getResult();
			
			$att->setTypeId($type[0]);
			
			$manager->persist($att);
			$manager->flush();
		}
		
		foreach ($NbrAttributes as $at => $lab)
		{
			$att = new attribute();
			$att->setName($at);
			$att->setLabel($lab);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :number');
			$qb->setParameter(':number', 'number');
				
			$type = $qb->getQuery()->getResult();
				
			$att->setTypeId($type[0]);
				
			$manager->persist($att);
			$manager->flush();
		}
		
		foreach ($TxtareaAttributes as $at => $lab)
		{
			$att = new attribute();
			$att->setName($at);
			$att->setLabel($lab);
			
			//Requete pour récuperer le type integer
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('t');
			$qb->from('adClassifiedBundle:type','t');
			$qb->Where('t.name = :textarea');
			$qb->setParameter(':textarea', 'textarea');
				
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