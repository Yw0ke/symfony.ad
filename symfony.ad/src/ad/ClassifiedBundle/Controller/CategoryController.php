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
use JMS\SecurityExtraBundle\Annotation\Secure;

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
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 * @Template()
	 */
	public function manageAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('adClassifiedBundle:Category');
		
		$arrayTree = array('root' => $repo->childrenHierarchy());

		return $this->container->get('templating')->renderResponse('adClassifiedBundle:Category:manage.html.twig', array(
				'category' => $arrayTree,
		));
	}
	
	/**
	 * @Route("/category/add/{slug}", name="ad_new_category")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 * @Template()
	 */
	public function addAction($slug)
	{
		if ($slug == 'none')
		{
			$category = new Category();
			
			$form = $this->createForm(new CategoryType(), $category); //, $adsParameter

			return $this->render('adClassifiedBundle:Category:new.html.twig', array ('form' => $form->createView(),
																					'slug' => $slug));
		}
		else
		{
			$category = new Category();
			
			$form = $this->createForm(new CategoryType(), $category); //, $adsParameter

			return $this->render('adClassifiedBundle:Category:new.html.twig', array ('form' => $form->createView(),
																					'slug' => $slug));
		
		}
	}
	
		/**
		 * @Route("/category/validate/{slug}", name="ad_validate_category")
		 * @Secure(roles="ROLE_SUPER_ADMIN")
		 * @Method({"POST"})
		 * @Template()
		 */
		public function validateAction($slug)
		{
			$form = $this->createForm(new CategoryType, new Category());
			
			$form->bindRequest($this->getRequest());
			if ($form->isValid())
			{
				if ($slug == 'none')
				{
					$cat = $form->getData();
						$em = $this->getDoctrine()->getEntityManager();
						
					$cat->setSlug('');
					$cat->setParent(null);
						
					$em->persist($cat);
					$em->flush();
						
					return $this->redirect($this->generateUrl('ad_manage_category'));
				}
				else 
				{
					$em = $this->getDoctrine()->getEntityManager();
					$repo = $em->getRepository('adClassifiedBundle:Category');
					$parent = $repo->findCatBySlug($slug);
						
					$cat = $form->getData();
					$em = $this->getDoctrine()->getEntityManager();
						
					$cat->setSlug('');
					$cat->setParent($parent[0]);
						
					$em->persist($cat);
					$em->flush();
						
					return $this->redirect($this->generateUrl('ad_manage_category'));
				}
			}
		}
	}