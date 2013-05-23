<?php

namespace ad\ClassifiedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use ad\ClassifiedBundle\Entity\Repository\CategoryRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="ad_index")
	 * @Template()
	 */
    public function indexAction()
    {
    	//Retourne les annonces r�centes.
    	
    	/*$user = $this->getUser();
    	
    	$userManager = $this->get('fos_user.user_manager');*/
    	
  		return $this->render('adClassifiedBundle:Default:index.html.twig',array());
    }
    
 	/**
	 * @Route("/dashboard/", name="ad_dashboard")
	 * @Template()
	 */
    public function dashboardAction()
    {
    	//$userManager = $this->get('fos_user.user_manager');
    	//$user = $userManager->findUserByUsername('admin');
    	
    	if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) 
    	{
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboardadmin.html.twig', array(  //Et on passe le tout � la vue.
    			));
    	}
    	else 
    	{
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboard.html.twig', array(  //Et on passe le tout � la vue.
    				));
    	}
    	
    	//$user = $this->container->get('security.context')->getToken()->getUser();

    }
}
