<?php
namespace ad\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ad\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{
		$userManager = $this->container->get('fos_user.user_manager');
		
		$userSAdmin = $userManager->createUser();
		$userModo = $userManager->createUser();
		$userUser = $userManager->createUser();
		
		$encoder = $this->container
						->get('security.encoder_factory')
						->getEncoder($userSAdmin);
		
		//Enregistrement du SuperAdmin
		$userSAdmin->setUsername('superadmin');
		$userSAdmin->setPassword($encoder
				  ->encodePassword('superadmin', $userSAdmin->getSalt()));
		$userSAdmin->setEmail('superadmin@superadmin.com');
		$userSAdmin->setEnabled(true);
		$userSAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
		$userManager->updateUser($userSAdmin, true);
		
		//Enregistrement de l'admin
		$userModo->setUsername('modo');
		$userModo->setPassword($encoder
				  ->encodePassword('modo', $userModo->getSalt()));
		$userModo->setEmail('modo@modo.com');
		$userModo->setEnabled(true);
		$userModo->setRoles(array('ROLE_MODO'));
		$userManager->updateUser($userModo, true);
		
		//Enregistrement de user
		$userUser->setUsername('user');
		$userUser->setPassword($encoder
            	  ->encodePassword('user', $userUser->getSalt()));
		$userUser->setEmail('user@user.com');
		$userUser->setEnabled(true);
		$userUser->setRoles(array('ROLE_USER'));
		$userManager->updateUser($userUser, true);
	}
}