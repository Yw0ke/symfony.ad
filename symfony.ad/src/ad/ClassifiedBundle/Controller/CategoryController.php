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
use ad\ClassifiedBundle\Form\CategoryType;
use ad\ClassifiedBundle\Entity\Category;

class CategoryController extends Controller
{
	/**
	 * @Route("/category/list/", name="ad_list_category")
	 * @Template()
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('adClassifiedBundle:Category');
		
		$arrayTree = $repo->childrenHierarchy();

		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Category:list.html.twig', array(
				'category' => $arrayTree
		));
		 
		//$userManager = $this->get('fos_user.user_manager');
		//$user = $userManager->findUserByUsername('admin');
		//$user->setRoles(array('ROLE_ADMIN'));
		//$test = $userManager->updateUser($user);
		 
		//var_dump($test);
		//die;
		 
		/*if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
		 // Sinon on déclenche une exception « Accès interdit »
		throw new AccessDeniedHttpException('Accès limité aux admins');
		}
		 
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Default:categoryList.html.twig', array(  //Et on passe le tout � la vue.
				'category' => $arrayTree
		));*/

	}
	
	/**
	 * @Route("/category/manage/", name="ad_manage_category")
	 * @Template()
	 */
	public function manageAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('adClassifiedBundle:Category');
	
		$arrayTree = $repo->childrenHierarchy();
		
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Category:manage.html.twig', array(
				'category' => $arrayTree
		));
	}
	
	/**
	 * @Route("/category/add/{name}", name="ad_add_category")
	 * @Template()
	 */
	public function addAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('adClassifiedBundle:Category');
	
		$arrayTree = $repo->childrenHierarchy();
	
		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Category:manage.html.twig', array(
				'category' => $arrayTree
		));
	}
}