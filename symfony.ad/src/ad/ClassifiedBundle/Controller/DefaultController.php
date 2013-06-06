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
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$category = $em->getRepository('adClassifiedBundle:Category')->childrenHierarchy();
    	
    	$ads = $em->getRepository('adClassifiedBundle:Ads')->getAllConfirmedAds();
    	
    	//var_dump($category);
    	//die;
  		
  		return $this->render('adClassifiedBundle:Default:index.html.twig',array('category' => $category,
  																				'ads' => $ads));
    }
    
 	/**
	 * @Route("/dashboard/", name="ad_dashboard")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
    public function dashboardAction()
    {
    	if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) 
    	{
    		$em = $this->getDoctrine()->getEntityManager();
		
			$ads = $em->getRepository('adClassifiedBundle:Ads')->getUnconfirmedAds();
			
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboardadmin.html.twig', array('ads' => $ads));
    	}
    	else 
    	{
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboard.html.twig', array());
    	}
    }
    
    /**
     * @Route("/category/render", name="ad_category")
     * @Template()
     */
    public function renderCategoryAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$category = $em->getRepository('adClassifiedBundle:Category')->childrenHierarchy();
    	
    	return $this->render('adClassifiedBundle:Default:category.html.twig',array('category' => $category));
    }
}
