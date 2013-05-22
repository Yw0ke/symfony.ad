<?php

namespace ad\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ads
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ad\ClassifiedBundle\Entity\Repository\AdsRepository")
 */
class Ads
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_name", type="string", length=42)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_type", type="string", length=42)
     */
    private $ownerType;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_adress", type="string", length=255)
     */
    private $ownerAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_city", type="string", length=42)
     */
    private $ownerCity;

    /**
     * @var integer
     *
     * @ORM\Column(name="owner_zip", type="integer")
     */
    private $ownerZip;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_country", type="string", length=42)
     */
    private $ownerCountry;

    /**
     * @var integer
     *
     * @ORM\Column(name="owner_phone", type="integer")
     */
    private $ownerPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_comment", type="text")
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer")
     */
    private $boatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer")
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Ads
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set ownerType
     *
     * @param string $ownerType
     * @return Ads
     */
    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;

        return $this;
    }

    /**
     * Get ownerType
     *
     * @return string 
     */
    public function getOwnerType()
    {
        return $this->ownerType;
    }

    /**
     * Set ownerAdress
     *
     * @param string $ownerAdress
     * @return Ads
     */
    public function setOwnerAdress($ownerAdress)
    {
        $this->ownerAdress = $ownerAdress;

        return $this;
    }

    /**
     * Get ownerAdress
     *
     * @return string 
     */
    public function getOwnerAdress()
    {
        return $this->ownerAdress;
    }

    /**
     * Set ownerCity
     *
     * @param string $ownerCity
     * @return Ads
     */
    public function setOwnerCity($ownerCity)
    {
        $this->ownerCity = $ownerCity;

        return $this;
    }

    /**
     * Get ownerCity
     *
     * @return string 
     */
    public function getOwnerCity()
    {
        return $this->ownerCity;
    }

    /**
     * Set ownerZip
     *
     * @param integer $ownerZip
     * @return Ads
     */
    public function setOwnerZip($ownerZip)
    {
        $this->ownerZip = $ownerZip;

        return $this;
    }

    /**
     * Get ownerZip
     *
     * @return integer 
     */
    public function getOwnerZip()
    {
        return $this->ownerZip;
    }

    /**
     * Set ownerCountry
     *
     * @param string $ownerCountry
     * @return Ads
     */
    public function setOwnerCountry($ownerCountry)
    {
        $this->ownerCountry = $ownerCountry;

        return $this;
    }

    /**
     * Get ownerCountry
     *
     * @return string 
     */
    public function getOwnerCountry()
    {
        return $this->ownerCountry;
    }

    /**
     * Set ownerPhone
     *
     * @param integer $ownerPhone
     * @return Ads
     */
    public function setOwnerPhone($ownerPhone)
    {
        $this->ownerPhone = $ownerPhone;

        return $this;
    }

    /**
     * Get ownerPhone
     *
     * @return integer 
     */
    public function getOwnerPhone()
    {
        return $this->ownerPhone;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Ads
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set boatId
     *
     * @param integer $boatId
     * @return Ads
     */
    public function setBoatId($boatId)
    {
        $this->boatId = $boatId;

        return $this;
    }

    /**
     * Get boatId
     *
     * @return integer 
     */
    public function getBoatId()
    {
        return $this->boatId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Ads
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Ads
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
