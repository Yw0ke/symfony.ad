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
use ad\ClassifiedBundle\Form\adsSearchType;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="ad_index")
	 * @Template()
	 */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$config = $config = $em->getRepository('adClassifiedBundle:config')->getConfig();
    	
    	$adsPnium = null;
    	$ads = $em->getRepository('adClassifiedBundle:Ads')->getConfirmedAds(null);
    	
    	if ($config->getWebsitePolicy() == 'notfree')
    	{
    		$adsPnium = $em->getRepository('adClassifiedBundle:Ads')->getPreniumAds();
    	}
    	
    	$paginator  = $this->get('knp_paginator');
    	
    	$pagination = $paginator->paginate(	$ads,
							    			$this->get('request')->query->get('page', 1)/*page number*/,
							    			$config->getResultsByPages()/*limit per page*/
    	);
    	
  		return $this->render('adClassifiedBundle:Default:index.html.twig',array('pagination' => $pagination,
  																				'prenium' => $adsPnium));
    }
    
    /**
     * @Route("/filter/{filter}", name="ad_filtered")
     * @Template()
     */
    public function filterAction($filter = null)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$config = $config = $em->getRepository('adClassifiedBundle:config')->getConfig();
    	
    	$category = $em->getRepository('adClassifiedBundle:Category')->findBy(array('slug' => $filter));
    	
    	$ads = $em->getRepository('adClassifiedBundle:Ads')->getConfirmedAds($filter);
    	$nbr = count($ads);
    	
    	$paginator  = $this->get('knp_paginator');
    	 
    	$pagination = $paginator->paginate(	$ads,
							    			$this->get('request')->query->get('page', 1)/*page number*/,
							    			$config->getResultsByPages()/*limit per page*/
							    			);
    	 
    	return $this->render('adClassifiedBundle:Default:filtered.html.twig', array('pagination' => $pagination,
																				   'category' => $category[0],
																				   'nbrResults' => $nbr));
    }
    
    /**
     * @Route("/buyaboat", name="ad_buyaboat")
     * @Template()
     */
    public function buyaboatAction()
    {
    	return $this->render('adClassifiedBundle:Default:bab.html.twig', array());
    }
    
 	/**
	 * @Route("/dashboard/", name="ad_dashboard")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
    public function dashboardAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$config = $config = $em->getRepository('adClassifiedBundle:config')->getConfig();
    	
    	if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) 
    	{
			$ads = $em->getRepository('adClassifiedBundle:Ads')->getUnconfirmedAds();
			
			$config = $em->getRepository('adClassifiedBundle:config')->getConfig();
			
			$paginator  = $this->get('knp_paginator');
			$pagination = $paginator->paginate(	$ads,
					$this->get('request')->query->get('page', 1)/*page number*/,
					$config->getResultsByPages()/*limit per page*/
					);
			
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboardadmin.html.twig', array('pagination' => $pagination,
    																																'policy' => $config->getWebsitePolicy()));
    	}
    	else 
    	{
    		$ads = $em->getRepository('adClassifiedBundle:Ads')->getUserAds($this->getUser());
    			
    		$config = $config = $em->getRepository('adClassifiedBundle:config')->getConfig();
    		
    		$paginator  = $this->get('knp_paginator');
    		$pagination = $paginator->paginate(	$ads,
    				$this->get('request')->query->get('page', 1)/*page number*/,
    				$config->getResultsByPages()/*limit per page*/
    		);
    		
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboard.html.twig', array('pagination' => $pagination,
    				));
    	}
    }
    
    /**
     * @Route("/category/renderCategory", name="ad_category")
     * @Template()
     */
    public function renderCategoryAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$category = $em->getRepository('adClassifiedBundle:Category')->childrenHierarchy();
    	
    	foreach ($category as $cat)
    	{
    		$cat['nb'] = 0;

    		$child = $cat['__children'];
    		
    		$cat['__children'] = array();
    		
    		foreach ($child as $sscat)
    		{
    			$childCounted = array();
    			
    			$sscat['nb'] = $em->getRepository('adClassifiedBundle:Category')->countAds($sscat['id']);
    			
    			$cat['nb'] += $sscat['nb'];
				
    			$cat['__children'][] = $sscat;
    		}
    		$cat['nb'] += $em->getRepository('adClassifiedBundle:Category')->countAds($cat['id']);
    		
    		$catCounted[] = $cat;
    	}
    	
    	return $this->render('adClassifiedBundle:Default:category.html.twig',array('category' => $catCounted));
    }
    
    
    
    /**
     * @Route("/category/renderOptions", name="ad_options")
     * @Template()
     */
    public function renderOptionsAction()
    {
    	$em = $this->getDoctrine()->getManager();

   		$category = $em->getRepository('adClassifiedBundle:Category')->childrenHierarchy();
     
   		return $this->render('adClassifiedBundle:Default:options.html.twig',array('category' => $category));
    }
    
}
