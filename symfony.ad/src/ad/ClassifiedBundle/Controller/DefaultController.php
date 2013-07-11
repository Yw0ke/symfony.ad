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
use ad\ClassifiedBundle\Form\adsSearchForm;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="ad_index")
	 * @Route("/filter/{filter}", name="ad_index_filtered")
	 * @Template()
	 */
    public function indexAction($filter = null)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$form = $this->container->get('form.factory')->create(new adsSearchForm());
    	$ads = $em->getRepository('adClassifiedBundle:Ads')->getConfirmedAds($filter);
    	
    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(	$ads,
							    			$this->get('request')->query->get('page', 1)/*page number*/,
							    			2/*limit per page*/
    	);
    	
  		return $this->render('adClassifiedBundle:Default:index.html.twig',array('pagination' => $pagination,
  																				'form' => $form->createView()));
    }
    
   
    
 	/**
	 * @Route("/dashboard/", name="ad_dashboard")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
    public function dashboardAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) 
    	{
			$ads = $em->getRepository('adClassifiedBundle:Ads')->getUnconfirmedAds();
			
			$paginator  = $this->get('knp_paginator');
			$pagination = $paginator->paginate(	$ads,
					$this->get('request')->query->get('page', 1)/*page number*/,
					2/*limit per page*/
					);
			
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboardadmin.html.twig', array('pagination' => $pagination));
    	}
    	else 
    	{
    		$ads = $em->getRepository('adClassifiedBundle:Ads')->getUserAds($this->getUser());
    			
    		$paginator  = $this->get('knp_paginator');
    		$pagination = $paginator->paginate(	$ads,
    				$this->get('request')->query->get('page', 1)/*page number*/,
    				2/*limit per page*/
    		);
    		
    		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:dashboard.html.twig', array('pagination' => $pagination,
    				));
    	}
    }
    
    /**
     * @Route("/category/render", name="ad_category")
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
    			
    			$cat['nb'] += $em->getRepository('adClassifiedBundle:Category')->countAds($sscat['id']);
				
    			$cat['__children'][] = $sscat;
    		}
    		$cat['nb'] += $em->getRepository('adClassifiedBundle:Category')->countAds($cat['id']);
    		
    		$catCounted[] = $cat;
    	}
    	
    	return $this->render('adClassifiedBundle:Default:category.html.twig',array('category' => $catCounted));
    }
}
