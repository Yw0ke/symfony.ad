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


class MessageController extends Controller
{
	/**
	 * @Route("/message", name="ad_new_message")
	 * @Template()
	 */
    public function newMessageAction()
    {
    	var_dump($_POST);
    	die;
    }
}