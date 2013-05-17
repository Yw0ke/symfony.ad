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
		//Ajout des cat�gories primaires.
		$maincategory = array("Bateaux d'occasion", "Bateaux neuf", "Jets skis", "Bateaux en location", "Divers", "Moteurs");
		
		foreach($maincategory as $name)
		{
			$cat = new Category();
			$cat->setName($name);
			
			$manager->persist($cat);
			$manager->flush();
		}
		
		//Ajout des cat�gories secondaire.
		$manager = $this->container->get('doctrine')->getEntityManager();
				
		$categoryX = array(
	    	"Bateaux de travail" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 1)),
	    	"Bateaux fluviaux" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 1)),
	    	"Bateaux à moteur" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array(	'id' => array(1, 2, 4))),	//array si sous-cat�gorie disponible sur plusieurs cat�gorie
	    	"Voiliers" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array( 'id' => array(2, 4))),			//array si sous-cat�gorie disponible sur plusieurs cat�gorie
	    	"Jets-skis à bras" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 3)),
	    	"Jets-skis à selle" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 3)),
	    	"Accastillages" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 5)),
	    	"Autres" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 5)),
	    	"Places de port" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 5)),
	    	"Moteurs d'occasion" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 6)),
	    	"Moteurs neufs" => $manager->getRepository('adClassifiedBundle:Category')->findBy(array('id' => 6)),
    	);
		
		foreach ($categoryX as $name => $parent)
		{
			if (!is_array(($parent)))	//Si il n'y en a pas plusieurs on persist l'entit� directement.
			{
				$cat = new Category();
				$cat->setName(utf8_encode($name));
				$cat->setParent($parent);
				
				$manager->persist($cat);
			}
			else 	//Sinon on boucle sur le "tableau" et on persisit une entit� a chaque boucle.
			{				
				foreach ($parent as $id)
				{	
					$cate = new Category();
					$cate->setName(utf8_encode($name));
					$cate->setParent($parent);
					
					$manager->persist($cate);
				}
			}
			$manager->flush();
		}
	}
}