<?php
namespace ad\ClassifiedBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\ClassifiedBundle\Entity\type;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadTypeData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getManager();

		$types = array('string', 'integer');

		foreach ($types as $type)
		{
			$ty = new type();
			$ty->setName($type);

			$manager->persist($ty);
			$manager->flush();
		}
	}

	public function getOrder()
	{
		return 3;
	}

}