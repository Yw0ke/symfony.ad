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
		
		function randomDate($start_date, $end_date)	//Fonction trouvé sur le net en cherchant un moyen de random une date.
		{
			// Convert to timetamps
			$min = strtotime($start_date);
			$max = strtotime($end_date);
		
			// Generate random number using above bounds
			$val = rand($min, $max);
		
			// Convert back to desired date format
			return date('Y-m-d H:i:s', $val);
		}
		
		$rdmdate1 = new \DateTime(randomDate('2012-01-01', '2013-05-31'));
		$rdmdate2 = new \DateTime(randomDate('2012-01-01', '2013-05-31'));
		$rdmdate3 = new \DateTime(randomDate('2012-01-01', '2013-05-31'));
		$rdmdate4 = new \DateTime(randomDate('2012-01-01', '2013-05-31'));		
		
		//Annonce valider par l'administrateur.		
		$ads = new Ads();
		$ads->setTitle('Bateau de pêche');
		$ads->setDate($rdmdate1);
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
		$ads->setDate($rdmdate2);
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
		$ads->setDate($rdmdate3);
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
		$ads->setDate($rdmdate4);
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