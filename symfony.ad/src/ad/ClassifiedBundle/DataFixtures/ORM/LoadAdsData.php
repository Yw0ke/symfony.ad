<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\Ads;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadAdsData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getEntityManager();
		
		//Annonce valider par l'administrateur.
		$ads = new Ads();
		$ads->setTitle('Bateau de pêche');
		$ads->setPrice(15000);
		$ads->setConfirmed(1);
		$ads->setOwnerType('Pro');
		$ads->setOwnerAdress('Osef');
		$ads->setOwnerCity('OsefLand');
		$ads->setOwnerZip('12000');
		$ads->setOwnerCountry('OsefLand');
		$ads->setOwnerPhone('0622075235');
		$ads->setComment('Très bon bateau blahblah');
		$ads->setBoatId(1); //a modif
		
		//Requete pour récuperer le bon category ID
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('c');
		$qb->from('adClassifiedBundle:Category','c');
		$qb->where("c.name = 'Bateaux de travail'");
		$cat = $qb->getQuery()->getResult();
		
		//Requete pour récuperer le bon user ID.
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('u');
		$qb->from('adUserBundle:User','u');
		$qb->where("u.username = 'user'");
		$user = $qb->getQuery()->getResult();
		
		$ads->setCategoryId($cat[0]);
		$ads->setUserId($user[0]);
		
		$manager->persist($ads);
		$manager->flush();
		
		
		$ads = new Ads();
		$ads->setTitle('Scooter des mers');
		$ads->setPrice(3000);
		$ads->setConfirmed(1);
		$ads->setOwnerType('Pro');
		$ads->setOwnerAdress('Osef');
		$ads->setOwnerCity('OsefLand');
		$ads->setOwnerZip('12000');
		$ads->setOwnerCountry('OsefLand');
		$ads->setOwnerPhone('0622075235');
		$ads->setComment('Vroom vroom');
		$ads->setBoatId(6); //a modif
		
		//Requete pour récuperer le bon category ID
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('c');
		$qb->from('adClassifiedBundle:Category','c');
		$qb->where("c.name = 'Jets-skis à selle'");
		$cat = $qb->getQuery()->getResult();
		
		//Requete pour récuperer le bon user ID.
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('u');
		$qb->from('adUserBundle:User','u');
		$qb->where("u.username = 'user'");
		$user = $qb->getQuery()->getResult();
		
		$ads->setCategoryId($cat[0]);
		$ads->setUserId($user[0]);
		
		$manager->persist($ads);
		$manager->flush();
		
		
		//Annonce non valider apr l'administrateur.
		$ads = new Ads();
		$ads->setTitle('Barque');
		$ads->setPrice(6000);
		$ads->setConfirmed(0);
		$ads->setOwnerType('Particulier');
		$ads->setOwnerAdress('Osef');
		$ads->setOwnerCity('OsefLand');
		$ads->setOwnerZip('12000');
		$ads->setOwnerCountry('OsefLand');
		$ads->setOwnerPhone('0623075235');
		$ads->setComment('Très bonne barque blahblah');
		$ads->setBoatId(2); //a modif
		
		//Requete pour récuperer le bon category ID
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('c');
		$qb->from('adClassifiedBundle:Category','c');
		$qb->where("c.name = 'Autres'");
		$cat = $qb->getQuery()->getResult();
		
		//Requete pour récuperer le bon user ID.
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('u');
		$qb->from('adUserBundle:User','u');
		$qb->where("u.username = 'user'");
		$user = $qb->getQuery()->getResult();
		
		$ads->setCategoryId($cat[0]);
		$ads->setUserId($user[0]);
		
		$manager->persist($ads);
		$manager->flush();
		
		
		
		
		$ads = new Ads();
		$ads->setTitle('Titanic');
		$ads->setPrice(30000);
		$ads->setConfirmed(0);
		$ads->setOwnerType('Particulier');
		$ads->setOwnerAdress('18 rue du refuge');
		$ads->setOwnerCity('Arles');
		$ads->setOwnerZip('13200');
		$ads->setOwnerCountry('France');
		$ads->setOwnerPhone('0623023535');
		$ads->setComment('Le fameux !');
		$ads->setBoatId(5); //a modif
		
		//Requete pour récuperer le bon category ID
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('c');
		$qb->from('adClassifiedBundle:Category','c');
		$qb->where("c.name = 'Autres'");
		$cat = $qb->getQuery()->getResult();
		
		//Requete pour récuperer le bon user ID.
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('u');
		$qb->from('adUserBundle:User','u');
		$qb->where("u.username = 'user'");
		$user = $qb->getQuery()->getResult();
		
		$ads->setCategoryId($cat[0]);
		$ads->setUserId($user[0]);
		
		$manager->persist($ads);
		$manager->flush();
		
		
		
		
	}
	
	public function getOrder()
	{
		return 2;
	}
}