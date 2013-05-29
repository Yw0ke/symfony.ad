<?php

namespace ad\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;
	
    /**
     * @var integer
  	 * @ORM\ManyToOne(targetEntity="ad\ClassifiedBundle\Entity\Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $categoryId;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ad\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $userId;
    
    /**
     * @var array
     */
    private $attribute;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName;
    
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file;
     
    public function getWebPath()
    {
    	return null === $this->pictureName ? null : $this->getUploadDir().'/'.$this->pictureName;
    }
    
    protected function getUploadRootDir()
    {
    	// le chemin absolu du répertoire dans lequel sauvegarder les photos de profil
    	return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
    	return 'uploads/pictures';
    }
     
    public function uploadPicture()
    {    
    	// move copie le fichier présent chez le client dans le répertoire indiqué.
    	$this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
    
    	// On sauvegarde le nom de fichier
    	$this->pictureName = $this->file->getClientOriginalName();
    	 
    	// La propriété file ne servira plus
    	$this->file = null;
    }

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
     * Add attribute
     *
     * @return array
     */
    public function addAttribute($attribute, $value)
    {
    	$this->attribute[$attribute] = $value;
    }
    
    /**
     * Get attribute
     *
     * @return array
     */
    public function getAttribute()
    {
    	return $this->attribute;
    }
    
    /**
     * Set attribute
     *
     * @param array $attribute
     * @return Ads
     */
    public function setAttribute($attribute)
    {
    	$this->attribute = $attribute;
    
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
     * Set pictureName
     *
     * @param string $pictureName
     * @return Ads
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string 
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * Set categoryId
     *
     * @param \ad\ClassifiedBundle\Entity\Category $categoryId
     * @return Ads
     */
    public function setCategoryId(\ad\ClassifiedBundle\Entity\Category $categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return \ad\ClassifiedBundle\Entity\Category 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set userId
     *
     * @param \ad\UserBundle\Entity\User $userId
     * @return Ads
     */
    public function setUserId(\ad\UserBundle\Entity\User $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \ad\UserBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
