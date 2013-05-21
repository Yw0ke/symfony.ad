<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadCategoryData implements FixtureInterface, ContainerAwareInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		//Ajout des catégories primaires.
		$maincategory = array("Bateaux d'occasion", "Bateaux neuf", "Jets skis", "Bateaux en location", "Divers", "Moteurs");
		
		$manager = $this->container->get('doctrine')->getEntityManager();
		
		foreach($maincategory as $name)
		{
			$cat = new Category();
			$cat->setName(utf8_encode($name));
			
						
			$manager->persist($cat);
			$manager->flush();
			
		}
		
		//Ajout des catï¿½gories secondaire.				
		$categoryX = array(
	    	"Bateaux de travail" => $maincategory[0],
	    	"Bateaux fluviaux" => $maincategory[0],
	    	"Bateaux à moteur" => $maincategory[0],	//array si sous-catï¿½gorie disponible sur plusieurs catï¿½gorie
	    	"Bateaux à moteur" => $maincategory[1],
			"Bateaux à moteur" =>$maincategory[3],
	    	"Voiliers" => $maincategory[1],			//array si sous-catï¿½gorie disponible sur plusieurs catï¿½gorie
	    	"Voiliers" => $maincategory[3],
	    	"Jets-skis à  bras" => $maincategory[2],
	    	"Jets-skis à  selle" => $maincategory[2],
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
			$cat->setName(utf8_encode($name));
			$cat->setParent($dad[0]);
			
			$manager->persist($cat);
			$manager->flush();
		}
	}
}