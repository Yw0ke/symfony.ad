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
	 * @Route("/ads/new/", name="ad_new_ads")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function newAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		
		//$attributeV = $em->getRepository("adClassifiedBundle:attributeValues")->findAll();
		//$adsParameter = new AdsParameter($attributeV, $edit=false); //$edit=true
		
		$att = $em->getRepository("adClassifiedBundle:attribute")->findAll();
		$mix = array();
		
		foreach ($att as $attribut)
		{
			$mix[$attribut->getName()] = null;
		}
		
		$ads = new Ads();
		$ads->setAttribute($mix);
		
		$form = $this->createForm(new AdsType(), $ads); //, $adsParameter
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
				$ads->uploadPicture();
				$ads->setUserId($this->getUser());
				$ads->setDate(new \DateTime('now')); 
				
				$em->persist($ads);
				
				foreach ($ads->getAttribute() as $attName => $value)
				{
					$att = $em->getRepository("adClassifiedBundle:attribute")->findByName($attName);
					$attValue = new attributeValues();
					
					$attValue->setValue($value);
					$attValue->setAdsId($ads);
					$attValue->setAttributeId($att[0]);
					
					$em->persist($attValue);
				}
				
				$em->flush();
				
				return $this->redirect($this->generateUrl('ad_index'));
		}	
		
		return $this->render('adClassifiedBundle:Ads:new.html.twig', array ('form' => $form->createView()));
	}
	
	/**
	 * @Route("/ads/manage", name="ad_manage_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function manageAdsAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$ads = $em->getRepository('adClassifiedBundle:Ads')->getAllAds();
		
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(	$ads,
				$this->get('request')->query->get('page', 1)/*page number*/,
				2/*limit per page*/
		);
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:manage.html.twig', array(
				'pagination' => $pagination
		));
	}
	
	/**
	 * @Route("/ads/delete/{id}", name="ad_delete_ads")
	 */
	public function deleteAdsAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$adObj = $em->getRepository("adClassifiedBundle:Ads")->findOneBy(array('id' => $id));
		$adHyd = $em->getRepository('adClassifiedBundle:Ads')->hydrateAd($adObj);
		
		if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN') || $adHyd->getUserId() == $this->getUser())
		{
			$ad = $em->getRepository('adClassifiedBundle:attributeValues')->getAttValFullInfoById($id);
			
			if (!$ad)
			{
				throw $this->createNotFoundException('Cette annonce n\'existe pas.');
			}
			
			foreach ($ad as $attVal)
			{
				$em->remove($attVal);
				$em->flush();
			}
	
			if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
			{
				return $this->redirect($this->generateUrl('ad_manage_ads', array('delete')));
			}
			else 
			{
				return $this->redirect($this->generateUrl('ad_dashboard', array('delete')));
			}
		}
		else
		{
			throw new AccessDeniedHttpException('Vous n\'avez pas les droits nécessaire à la suppression d\'utilisateurs.');
		}
	}
	
	/**
	 * @Route("/ads/confirm/{id}/{dash}", name="ad_confirm_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function confirmAdsAction($id, $dash)
	{
		$em = $this->getDoctrine()->getManager();
	
		$ad = $em->getRepository('adClassifiedBundle:attributeValues')->getAttValFullInfoById($id);
		
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
		$em = $this->getDoctrine()->getManager();
		$ad = $em->getRepository("adClassifiedBundle:Ads")->findOneBy(array('id' => $id));
	
		$ads = $em->getRepository('adClassifiedBundle:Ads')->hydrateAd($ad);
		
		$ads = $ad->setViewCount($ad->getViewCount() +1);
		
		$em->persist($ad);
		$em->flush();
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Ads:details.html.twig', array(
				'ad' => $ad
		));
	}
	
	/**
	 * @Route("/ads/edit/{id}", name="ad_edit_ads")

	 */
	public function editAdsAction(Request $request, $id = null)
	{
		$em = $this->getDoctrine()->getManager();
		
		//$attributeV = $em->getRepository("adClassifiedBundle:attributeValues")->findAll();
		//$adsParameter = new AdsParameter($attributeV, $edit=false); //$edit=true

			$ad = $em->getRepository("adClassifiedBundle:Ads")->findOneBy(array('id' => $id));
			$ads = $em->getRepository("adClassifiedBundle:Ads")->hydrateAd($ad);
			
			$form = $this->createForm(new AdsType(), $ads); //, $adsParameter

		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$ads->uploadPicture();
			$ads->setUserId($this->getUser());
			$ads->setDate(new \DateTime('now'));
			
			$em->persist($ads);
			
			foreach ($ads->getAttribute() as $attName => $value)
			{
				$att = $em->getRepository("adClassifiedBundle:attribute")->findByName($attName);
				$attValue = new attributeValues();
				
				$attValue->setValue($value);
				$attValue->setAdsId($ads);
				$attValue->setAttributeId($att[0]);
				
				$em->persist($attValue);
			}
		
			$em->flush();
		
			return $this->redirect($this->generateUrl('ad_dashboard', array('update')));
		}
		
		return $this->render('adClassifiedBundle:Ads:edit.html.twig', array ('form' => $form->createView(),
																			 'id' => $id));
	}
}
	
