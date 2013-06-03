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
		$ads->setPictureName('photo1.png');
		
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
		$ads->setTitle('pedalo');
		$ads->setPictureName('photo2.png');
		
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
		$ads->setPictureName('photo3.png');
		
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
		$ads->setPictureName('photo4.png');
		
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