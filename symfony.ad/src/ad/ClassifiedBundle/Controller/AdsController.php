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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use ad\ClassifiedBundle\Form\AdsType;
use ad\ClassifiedBundle\Entity\Ads;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
		if (!$this->get('security.context')->isGranted('ROLE_USER'))
		{
			throw new AccessDeniedHttpException('Accès limité aux utilisateurs inscrit !');	// Sinon on déclenche une exception « Accès interdit »
		}
		$formAds = $this->createForm(new AdsType, new Ads);
		$formBoat = $this->createForm(new BoatType, new Boat);
		
		return $this->render('adClassifiedBundle:Ads:new.html.twig', array('form' => $formAds->createView()));
	}
	
	
	/**
	 * @Route("/ads/create", name="ad_save_ads")
	 */
	public function createAction(Request $request)
	{
		$form = $this->createForm(new AdsType, new Ads);
	
		if ('POST' == $request->getMethod())
		{
			$form->bind($request);
	
			if ($form->isValid())
			{
				$data = $form->getData();
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($data);
				$em->flush();
	
				return $this->redirect($this->generateUrl('ad_list_ads'));
			}
		}
	
		return $this->render('adClassifiedBundle:Ads:new.html.twig', array('form' => $form->createView()));
	}
	
	/**
	 * @Route("/ads/manage", name="ad_manage_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function manageAdsAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$ads = $em->getRepository('adClassifiedBundle:Ads')->findAll();
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:manage.html.twig', array(
				'ads' => $ads
		));
	}
	
	
}
	
