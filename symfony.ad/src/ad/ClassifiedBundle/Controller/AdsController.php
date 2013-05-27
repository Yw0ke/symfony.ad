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
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function newAction()
	{
		$ads = new Ads();
           
        $form = $this->createForm(new AdsType(), $ads);

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
               
                $ads->uploadPicture();
               
                $em->persist($ads);
                $em->flush();

                $this->redirect($this->generateUrl('ad_list_ads'));
            }
        }
        
        return $this->render('adClassifiedBundle:Ads:new.html.twig',
                array (
                    'ads' => $ads,
                    'form' => $form->createView()
                    )
                );
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
	
	/**
	 * @Route("/ads/delete/{id}", name="ad_delete_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function deleteAdsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		$ad = $em->getRepository('adClassifiedBundle:Ads')->find($id);
		
		if (!$ad)
		{
			throw $this->createNotFoundException('Cette annonce n\'existe pas.');
		}
		
		$em->remove($ad);
		$em->flush();
	
		return $this->redirect($this->generateUrl('ad_manage_ads', array('delete')));
	}
	
	/**
	 * @Route("/ads/confirm/{id}/{dash}", name="ad_confirm_ads")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 */
	public function confirmAdsAction($id, $dash)
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		$ad = $em->getRepository('adClassifiedBundle:Ads')->find($id);
		
		if ($ad->getConfirmed() == 0)
		{
			$ad->setConfirmed(1);
		}
		else
		{
			$ad->setConfirmed(0);
		}
		
		$em->persist($ad);
		$em->flush();
		
		if($dash == 1)
		{
			return $this->redirect($this->generateUrl('ad_dashboard', array('update')));
		}
		else 
		{
			return $this->redirect($this->generateUrl('ad_manage_ads', array('update')));
		}
	}
}
	
