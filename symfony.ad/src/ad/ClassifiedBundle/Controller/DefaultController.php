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

class DefaultController extends Controller
{
	/**
	 * @Route("", name="index")
	 * @Template()
	 */
    public function indexAction()
    {
    	//Retourne les annonces récentes.
    	
    	$user = $this->getUser();
    	
    	$userManager = $this->get('fos_user.user_manager');
    	
  		return $this->render('adClassifiedBundle:Default:index.html.twig',array());
    }
    
    /**
     * @Route("", name="categoryList")
     * @Template()
     */
    public function categoryListAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$category = $em->getRepository('adClassifiedBundle:Category')->getCategory();
    	
    	return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:categoryList.html.twig', array(  //Et on passe le tout à la vue.
    			'category' => $category
    	));
    	
    }
    
    
}
