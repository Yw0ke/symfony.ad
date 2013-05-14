<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Occupation par une cat�gorie fictive de l'id 1 de la BDD pour que lla premi�re entrer commence � 2.
		$cat = new Category();
		$cat->setName('none');
		$cat->setParentId(0);
		
		$manager->persist($cat);
		$manager->flush();
		
		//Ajout des cat�gories primaires.
		$category1 = array("Bateaux d'occasion", "Bateaux neuf", "Jets skis", "Bateaux en location", "Divers", "Moteurs");
		
		foreach($category1 as $name)
		{
			$cat = new Category();
			$cat->setName($name);
			$cat->setParentId(1);
			
			$manager->persist($cat);
			$manager->flush();
		}
		
		//Ajout des cat�gories secondaire.
		$categoryX = array(
				"Bateaux de travail" => "2",
				"Bateaux fluviaux" => "2",
				"Bateaux � moteur" => array("3", "2", "5"),	//array si sous-cat�gorie disponible sur plusieurs cat�gorie
				"Voiliers" => array("5", "3"),	//array si sous-cat�gorie disponible sur plusieurs cat�gorie
				"Jets-skis � bras" => "4",
				"Jets-skis � selle" => "4",
				"Accastillages" => "6",
				"Autres" => "6",
				"Places de port" => "6",
				"Moteurs d'occasion" => "7",
				"Moteurs neufs" => "7",
		);
		
		foreach ($categoryX as $name => $parentId)
		{
			if (!is_array($parentId))	//Si il n'y en a pas plusieurs on persist l'entit� directement.
			{			
				$cat = new Category();
				$cat->setName(utf8_encode($name));
				$cat->setParentId($parentId);
					
				$manager->persist($cat);
			}
			else 	//Sinon on boucle sur le "tableau" et on persisit une entit� a chaque boucle.
			{
				$i = 0;
				
				foreach ($parentId as $id)
				{	
					$cate = new Category();
					$cate->setName(utf8_encode($name));
					$cate->setParentId($id);
					
					$manager->persist($cate);

					$i++;
				}
			}
			$manager->flush();
		}
	}
}