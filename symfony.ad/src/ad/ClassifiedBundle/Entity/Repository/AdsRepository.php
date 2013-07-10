<?php

namespace ad\ClassifiedBundle\Entity\Repository;

use Doctrine\ORM\Query\Parameter;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\EntityRepository;
use ad\ClassifiedBundle\Entity\attribute_values;
use ad\ClassifiedBundle\Entity\Ads;

/**
 * AdsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdsRepository extends EntityRepository
{
	/**
	 * Hydrate ad's attribute.
	 *
	 * @return Ads
	 */
	public function hydrateAd(Ads $ad)
	{
		$em = $this->getEntityManager();
		
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		$qb->where('v.AdsId = :id');
		
		$qb->setParameter('id', $ad->getId());
		
		$response = $qb->getQuery()->getResult();
		
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
			
			$ad->addAttribute($attribute, $value);
		}
		
		return $ad;
	}
	
	/**
	 * Check if ad is confirmed
	 *
	 * @return Ads
	 */
	public function isConfirmed(Ads $ad)
	{
		foreach ($ad->getAttribute() as $att => $val)
		{
			if ($att == 'Confirmed' && $val == 0)
			{
				return false;
			}
			elseif ($att == 'Confirmed' && $val == 1)
			{
				return true;
			}
		}
	}
	/**
	 * Get unconfirmed ads's minimum info for dashboardadmin.
	 *
	 * @return array(Ads)
	 */
	public function getUnconfirmedAds()
	{
		$em = $this->getEntityManager();
	
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');;
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		$qb->where('attr.name = :price');
		$qb->orWhere('attr.name = :ownerType');
		$qb->orWhere('attr.name = :ownerCity');
		$qb->orWhere('attr.name =:Confirmed');
		
		if (!empty($_GET['sort']))
		{
			$qb->orderBy($_GET['sort'], $_GET['direction']);	//knp_paginator sort
		}
		else
		{
			$qb->orderBy('ads.date',  $order = 'DESC');
		}
		
		$qb->setParameters(new ArrayCollection(array(
													 new Parameter(':price', 'Price'),
													 new Parameter(':ownerType', 'OwnerType'),
													 new Parameter(':ownerCity', 'OwnerCity'),
													 new Parameter(':Confirmed', 'Confirmed')
													 )));

		$response = $qb->getQuery()->getResult();
		
		$ads = array();
		
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
			
			$ad = $attVal->getAdsId();

			$ad->addAttribute($attribute, $value);
			
			$ads[$ad->getId()] = $ad;
			
			$att = $ads[$ad->getId()]->getAttribute();

			if (isset($att['Confirmed']) && $att['Confirmed'] != 0)	//Tri des entité non confirmer.
			{
				unset($ads[$ad->getId()]);
			}			
		}
		
		foreach ($ads as $ad)	//Boucle qui retire la paire Confirmed => Value, non souhaiter ici.
		{
			$att = $ad->getAttribute();
			unset($att['Confirmed']);
			$ad->setAttribute($att);
			
			$ads[$ad->getId()] = $ad;
		}
		
		return $ads;	//retour d'un tableau d'entité Ads avec Attribut => Valeur
	}
	
	/**
	 * Get all ads's info for manage ads.
	 *
	 * @return array(Ads)
	 */
	public function getAllAds()
	{
		$em = $this->getEntityManager();
	
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');;
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		$qb->orderBy('ads.date',  $order = 'DESC');
		
		$response = $qb->getQuery()->getResult();
		
		$ads = array();
		
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
				
			$ad = $attVal->getAdsId();
		
			$ad->addAttribute($attribute, $value);
				
			$ads[$ad->getId()] = $ad;
		}
		
		return $ads;
	}
	
	/**
	 * Get confirmed ads's info for index.
	 *
	 * @return array(Ads)
	 */
	public function getConfirmedAds($filter = null)
	{		
		$em = $this->getEntityManager();
		
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');
		$qb->addSelect('c');
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		$qb->leftJoin('ads.categoryId', 'c');
		
		if (!is_null($filter))	//Range de la recherche s'étend au sous-catégories.
		{
			$cat = $em->getRepository('adClassifiedBundle:Category')->findCatBySlug($filter);
			
			$qb->where('c.slug = :filter');
			$qb->orWhere('c.root = :root');
			
			$qb->setParameter(':root', $cat->getRoot());
			$qb->setParameter(':filter', $filter);
		}
		
		if (!empty($_GET['sort']))
		{
			$qb->orderBy($_GET['sort'], $_GET['direction']);	//knp_paginator sort
		}
		else
		{
			$qb->orderBy('ads.date',  $order = 'DESC');
		}
		
		$response = $qb->getQuery()->getResult();
		
		$ads = array();
	
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
			
			$ad = $attVal->getAdsId();
			$ad->addAttribute($attribute, $value);
			
			$try = $ad->getAttribute();
			
			if (isset($try['Confirmed']) && $try['Confirmed'] == 1)
			{
				$ads[$ad->getId()] = $ad;
			}
		}
		
		return $ads;
	}
	
	/**
	 * Get loged user's ad.
	 *
	 * @return array(Ads)
	 */
	public function getUserAds($user)
	{
		$em = $this->getEntityManager();
	
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		$qb->where('ads.userId = :user');
		
		if (!empty($_GET['sort']))
		{
			$qb->orderBy($_GET['sort'], $_GET['direction']);	//knp_paginator sort
		}
		else
		{
			$qb->orderBy('ads.date',  $order = 'DESC');
		}
		
		$qb->setParameter(':user', $user);
		
		$response = $qb->getQuery()->getResult();
		
		$ads = array();
		
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
				
			$ad = $attVal->getAdsId();
			$ad->addAttribute($attribute, $value);
			
			$ads[$ad->getId()] = $ad;
		}
		
		return $ads;
	}
	
	
	/**
	 * Find ad by title like $this.
	 *
	 * @return array(Ads)
	 */
	public function findByTitleLike($title)
	{
		$em = $this->getEntityManager();
		
		$qb = $em->createQueryBuilder();
		$qb->addSelect('v');
		$qb->addSelect('ads');
		$qb->addSelect('attr');
		$qb->from('adClassifiedBundle:attributeValues','v');
		$qb->leftJoin('v.AdsId', 'ads');
		$qb->leftJoin('v.attributeId', 'attr');
		
		$qb->where("ads.title like '%$title%'");
		
		$response = $qb->getQuery()->getResult();
		
		$ads = array();
		
		foreach ($response as $attVal)
		{
			$value = $attVal->getValue();
			$attribute = $attVal->getAttributeId()->getName();
				
			$ad = $attVal->getAdsId();
			$ad->addAttribute($attribute, $value);
			
			$ads[$ad->getId()] = $ad;
		}
		
		return $ads;
	}
}
