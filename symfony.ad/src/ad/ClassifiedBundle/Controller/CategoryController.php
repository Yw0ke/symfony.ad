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
	public function addAction($slug, Request $request)
	{
		$category = new Category();
		
		$form = $this->createForm(new CategoryType(), $category); //, $adsParameter

		$form->handleRequest($request);
		
		if ($form->isValid())
		{
			if ($slug == 'none')
			{
				$cat = $form->getData();
				$em = $this->getDoctrine()->getManager();
					
				$cat->setSlug('');
				$cat->setParent(null);
					
				$em->persist($cat);
				$em->flush();
					
				return $this->redirect($this->generateUrl('ad_manage_category'));
			}
			else
			{
				$em = $this->getDoctrine()->getManager();
				$repo = $em->getRepository('adClassifiedBundle:Category');
				$parent = $repo->findCatBySlug($slug);
					
				$cat = $form->getData();
				$em = $this->getDoctrine()->getManager();
					
				$cat->setSlug('');
				$cat->setParent($parent);
					
				$em->persist($cat);
				$em->flush();
					
				return $this->redirect($this->generateUrl('ad_manage_category'));
			}
		}
		
		return $this->render('adClassifiedBundle:Category:new.html.twig', array ('form' => $form->createView(),
																				 'slug' => $slug));
	}
	

	
	/**
	 * @Route("/category/edit/{slug}", name="ad_edit_category")
	 * @Secure(roles="ROLE_SUPER_ADMIN")
	 * @Template()
	 */
	public function editAction($slug)
	{
		if ($slug == 'none')
		{
			throw new \Exception('La racine ne peut pas être choisie');
		}
		
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository('adClassifiedBundle:Category')->findCatBySlug($slug);
		
		if (!$category)
		{
			throw $this->createNotFoundException('La catégorie n\'existe pas.');
		}
		$id = $category->getId();
		$form = $this->createForm(new CategoryType, $category);
		
		return $this->render('adClassifiedBundle:Category:edit.html.twig', array('form' => $form->createView(), 'id' => $id));
		
	}
	
	/**
	 * @Route("/category/update/{id}", name="ad_update_category")
	 * @Template()
	 */
	public function updateAction($id)
	{
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository('adClassifiedBundle:Category')->find($id);
		$form = $this->createForm(new CategoryType, $category);
	
		if ('POST' == $request->getMethod())
		{
			$form->bind($request);
			if ($form->isValid())
			{
				$data = $form->getData();
				$em = $this->getDoctrine()->getManager();
				$em->persist($data);
				$em->flush();
				return $this->redirect($this->generateUrl('ad_manage_category'));
			}
		}
		return $this->render('adClassifiedBundle:Category:edit.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	/**
	 * @Route("/category/delete/{slug}", name="ad_delete_category")
	 * @Template()
	 */
	public function deleteAction($slug)
	{
		if ($slug == 'none')
		{
			throw new \Exception('La racine ne peut pas être choisie');
		}
		
		$em = $this->getDoctrine()->getManager();	//la même que celle du cours
		$entity = $em->getRepository('adClassifiedBundle:Category')->findCatBySlug($slug);
	
		if (!$entity)
		{
			throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
		}
	
		$em->remove($entity);
		$em->flush();
	
		return $this->redirect($this->generateUrl('ad_manage_category'));
	}
}