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
use ad\ClassifiedBundle\Entity\config;
use JMS\SecurityExtraBundle\Annotation\Secure;

class ConfigController extends Controller
{
	/**
	 * @Route("/config/switch-policy/", name="ad_config_switch_policy")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 * @Template()
	 */
	public function switchPolicyAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$config = $em->getRepository('adClassifiedBundle:config')->getConfig();
		
		if ($config->getWebsitePolicy() == 'free')
		{
			$config->setWebsitePolicy('notfree');
		}
		else
		{
			$config->setWebsitePolicy('free');
		}
		
		$em->persist($config);
		$em->flush();
		
		return $this->redirect($this->generateUrl('ad_dashboard'));
		
	}
}

