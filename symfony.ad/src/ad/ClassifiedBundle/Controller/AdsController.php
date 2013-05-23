<?php
namespace ad\ClassifiedBundle\Controller;

use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ad\ClassifiedBundle\Form\AdsType;
use ad\ClassifiedBundle\Entity\Ads;

class AdsController extends Controller
{
	/**
	 * @Route("/ads/list/", name="ad_list_ads")
	 * @Template()
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$ads = $em->getRepository('adClassifiedBundle:Ads')->findAll();
		
		//var_dump($ads);
		//die;
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:list.html.twig', array(
				'ads' => $ads
		));
		
	}
	
	/**
	 * @Route("/ads/new/", name="ad_new_ads")
	 * @Template()
	 */
	public function newAction()
	{
		$form = $this->createForm(new AdsType, new Ads);
		
		return $this->render('CnamCatClinicBundle:visite:new.html.twig', array('form' => $form->createView()));
	}
}
	
