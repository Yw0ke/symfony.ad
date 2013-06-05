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
use ad\ClassifiedBundle\Form\AdsParameterType;
use ad\ClassifiedBundle\Entity\Ads;
use ad\ClassifiedBundle\Entity\attribute;
use ad\ClassifiedBundle\Entity\attributeValues;
use JMS\SecurityExtraBundle\Annotation\Secure;
use ad\ClassifiedBundle\Form\AdsParameter;

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
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function newAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		//$attributeV = $em->getRepository("adClassifiedBundle:attributeValues")->findAll();
		//$adsParameter = new AdsParameter($attributeV, $edit=false); //$edit=true
		
		$att = $em->getRepository("adClassifiedBundle:attribute")->findAll();
		$attVal = new attributeValues();
		$mix = array();
		
		foreach ($att as $attribut)
		{
			$mix[$attribut->getName()] = $attVal->getValue();
		}
		
		$ads = new Ads();
		$ads->setAttribute($mix);
		
		/*$repo = $em->getRepository('adClassifiedBundle:Category');		
		$category['data'] = $arrayTree = $repo->childrenHierarchy();*/

		
		$form = $this->createForm(new AdsType(), $ads); //, $adsParameter
		
		if ($this->getRequest()->getMethod() === 'POST') {
			$form->bindRequest($this->getRequest());
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$ads->uploadPicture();
				$ads->setUserId($this->getUser());
				
				$em->persist($ads);
				
				foreach ($ads->getAttribute() as $attName => $attVal)
				{
					$att = $em->getRepository("adClassifiedBundle:attribute")->findByName($attName);
					
					$attVal->setAdsId($ads);
					$attVal->setAttributeId($att[0]);
					
					$em->persist($attVal);
				}
				
				$em->flush();
				
				return $this->redirect($this->generateUrl('ad_manage_ads'));
			}
		}
		
		return $this->render('adClassifiedBundle:Ads:new.html.twig', array ('form' => $form->createView()));
	}
	
	/**
	 * @Route("/ads/manage", name="ad_manage_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function manageAdsAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$ads = $em->getRepository('adClassifiedBundle:Ads')->getAllAds();
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:manage.html.twig', array(
				'ads' => $ads
		));
	}
	
	/**
	 * @Route("/ads/delete/{id}", name="ad_delete_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function deleteAdsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		$ad = $em->getRepository('adClassifiedBundle:Ads')->getAttValFullInfoById($id);
		
		if (!$ad)
		{
			throw $this->createNotFoundException('Cette annonce n\'existe pas.');
		}
		
		foreach ($ad as $attVal)
		{
			$em->remove($attVal);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('ad_manage_ads', array('delete')));
	}
	
	/**
	 * @Route("/ads/confirm/{id}/{dash}", name="ad_confirm_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function confirmAdsAction($id, $dash)
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		$ad = $em->getRepository('adClassifiedBundle:Ads')->getAttValFullInfoById($id);
		
		foreach ($ad as $attVal)
		{
			$att = $attVal->getAttributeId()->getName();
			
			if ($att == 'Confirmed' && $attVal->getValue() == 0)
			{
				$attVal->setValue(1);
			}
			elseif ($att == 'Confirmed' && $attVal->getValue() == 1)
			{
				$attVal->setValue(0);
			}
			
			$em->persist($attVal);
			$em->flush();
		}

		if($dash == 1)
		{
			return $this->redirect($this->generateUrl('ad_dashboard', array('update')));
		}
		else 
		{
			return $this->redirect($this->generateUrl('ad_manage_ads', array('update')));
		}
	}
	
	/**
	 * @Route("/ads/details/{id}", name="ad_details_ads")
	 */
	public function detailsAdsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		$ad = $em->getRepository('adClassifiedBundle:Ads')->getAdsFullInfoById($id);
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:details.html.twig', array(
				'ad' => $ad
		));
	}
}
	
