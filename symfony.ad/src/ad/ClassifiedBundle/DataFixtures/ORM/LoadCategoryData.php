<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadCategoryData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		//Ajout des cat�gories primaires.
		$maincategory = array("Bateaux d'occasion", "Bateaux neuf", "Jets skis", "Bateaux en location", "Divers", "Moteurs");
		
		$manager = $this->container->get('doctrine')->getManager();
		
		foreach($maincategory as $name)
		{
			$cat = new Category();
			$cat->setName($name);
			$cat->setSlug(''); //!!!!!!!!!!!
			
			
			$manager->persist($cat);
			$manager->flush();
			
		}
		
		//Ajout des cat�gories secondaire.				
		$categoryX = array(
	    	"Bateaux de travail" => $maincategory[0],
	    	"Bateaux fluviaux" => $maincategory[0],
	    	"Bateaux à moteur" => $maincategory[0],	//array si sous-cat�gorie disponible sur plusieurs cat�gorie
	    	"Bateaux à moteur" => $maincategory[1],
			"Bateaux à moteur" =>$maincategory[3],
	    	"Voiliers" => $maincategory[1],			//array si sous-cat�gorie disponible sur plusieurs cat�gorie
	    	"Voiliers" => $maincategory[3],
	    	"Jets-skis à bras" => $maincategory[2],
	    	"Jets-skis à selle" => $maincategory[2],
	    	"Accastillages" => $maincategory[4],
	    	"Autres" => $maincategory[4],
	    	"Places de port" => $maincategory[4],
	    	"Moteurs d'occasion" => $maincategory[5],
	    	"Moteurs neufs" => $maincategory[5],
    	);

		foreach ($categoryX as $name => $parent)
		{
			$qb = $manager->createQueryBuilder();
			$qb->addSelect('c');
			$qb->from('adClassifiedBundle:Category','c');
			$qb->where("c.name = :name");
				
			$qb->setParameter('name', $parent);
			
			$dad = $qb->getQuery()->getResult();
			
			$cat = new Category();
			$cat->setName($name);
			$cat->setParent($dad[0]);
			
			$manager->persist($cat);
			$manager->flush();
		}
	}
	
	public function getOrder()
	{
		return 1;
	}
}