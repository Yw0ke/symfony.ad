<?php

namespace ad\BuyBoatBundle\Controller;

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
    	$user = $this->getUser();
    	
    	$userManager = $this->get('fos_user.user_manager');
    	
  		return $this->render('adBuyBoatBundle:Default:index.html.twig',array());
    }
    public function ajouterAction()
    {
    	// On teste que l'utilisateur dispose bien du rôle ROLE_AUTEUR
    	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
    		// Sinon on déclenche une exception « Accès interdit »
    		throw new AccessDeniedHttpException('Accès limité aux admins');
    	}
    
    	// … Ici le code d'ajout d'un article qu'on a déjà fait
    }
    
    
}
