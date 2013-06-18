<?php
namespace ad\UserBundle\Controller;

use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ad\UserBundle\Form\UserType;
use ad\UserdBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\UserBundle\Controller\ProfileController as FosUser;

class UserController extends Controller
{
	/**
	 * Show action
	 */
	public function showAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();

	
		return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user));
	}
	
	/**
	 * @Route("/user/manage", name="ad_manage_user")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function manageAdsAction()
	{
    	$em = $this->getDoctrine()->getManager();
			
		$users = $em->getRepository('adUserBundle:User')->findAllSorted();
		
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(	$users,
				$this->get('request')->query->get('page', 1)/*page number*/,
				2/*limit per page*/
		);
	
		return $this->container->get('templating')->renderResponse('adUserBundle:User:manage.html.twig', array(
				'pagination' => $pagination
		));
	}
	
	/**
	 * @Route("/user/details/{id}", name="ad_details_user")
	 */
	public function detailsUserAction($id)
	{
		$em = $this->getDoctrine()->getManager();
	
		$user = $em->getRepository('adUserBundle:User')->findById($id);
		
		return $this->container->get('templating')->renderResponse('adUserBundle:User:details.html.twig', array(
				'user' => $user[0]
		));
	}
	
	/**
	 * @Route("/user/delete/{id}", name="ad_delete_user")
	 */
	public function deleteUserAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$user = $em->getRepository('adUserBundle:User')->findById($id);
		
		if (!$user)
		{
			throw $this->createNotFoundException('Cette utilisateur n\'existe pas.');
		}
		
		if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') || $user[0] == $this->getUser())
		{
			
			$em->remove($user[0]);
			$em->flush();
			
			if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
			{
				return $this->redirect($this->generateUrl('ad_manage_user', array('delete')));
			}
			else 
			{
				return $this->redirect($this->generateUrl('ad_index', array('delete')));
			}
		}
		else
		{
			throw new AccessDeniedHttpException('Vous n\'avez pas les droits nécessaire à la suppression d\'utilisateurs.');
		}
	}
	
	
	
	
	
	
	
	
	
}