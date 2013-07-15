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
use ad\ClassifiedBundle\Entity\message;
use ad\ClassifiedBundle\Form\messageType;

class MessageController extends Controller
{
	/**
	 * @Route("/message", name="ad_new_message")
	 * @Template()
	 */
    public function newMessageAction(Request $request)
    {
    	
    	$contact = new message();
    	$form = $this->createForm(new messageType(), $contact); //, $adsParameter
    	
	    $form->handleRequest($request);
	    
		if ($form->isValid()) {	
			
	            $message = \Swift_Message::newInstance()
			        ->setSubject($contact->getObject())
			        ->setFrom($contact->getSenderEmail())
			        ->setTo('yw0ke@hotmail.fr')
			        ->setBody($this->renderView('adClassifiedBundle:Message:Email.txt.twig', array('message' => $contact)));
		        $this->get('mailer')->send($message);
	
	            return $this->redirect($this->generateUrl('ad_dashboard'));
	    }
	
	    return $this->render('adClassifiedBundle:Message:_form.html.twig', array(
	        'form' => $form->createView(),
	    	'user' => $this->getUser()
	    ));
    }
}