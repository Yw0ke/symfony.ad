<?php

namespace ad\ClassifiedBundle\Entity;

use Symfony\Component\Validator\Constraints\Date;

use Doctrine\Common\Collections\ArrayCollection;

use Intervention\Image\Image;
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
     * @Assert\NotBlank()
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas correcte.")
     * @Assert\Length(
     *      min = "10",
     *      max = "50",
     *      minMessage = "Un minimum de {{ limit }} caractère est requis.|Un minimum de {{ limit }} caractères est requis.",
     *      maxMessage = "Une limite de {{ limit }} caractère est imposer.|Un minimum de {{ limit }} caractères est imposer."
     * )
     */
    private $title;
    
    /**
     * @var Date()
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
	
    /**
     * @var integer
  	 * @ORM\ManyToOne(targetEntity="ad\ClassifiedBundle\Entity\Category", cascade={"persist"})
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $categoryId;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ad\UserBundle\Entity\User", cascade={"persist"})
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $userId;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="viewcount", type="integer", nullable=true)
     */
    private $viewCount;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="prenium", type="integer", nullable=true)
     */
    private $prenium;
    
    /**
     * @var array
     */
    private $attribute;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName1;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName2;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName3;
    
    /**
     * @Assert\Image(
     *     minWidth = 800,
     *     maxWidth = 2200,
     *     minHeight = 600,
     *     maxHeight = 1800
     * )
     */
    public $pic;
    
    /**
     * @Assert\Image(
     *     minWidth = 800,
     *     maxWidth = 2200,
     *     minHeight = 600,
     *     maxHeight = 1800
     * )
     */
    public $pic1;
    
    /**
     * @Assert\Image(
     *     minWidth = 800,
     *     maxWidth = 2200,
     *     minHeight = 600,
     *     maxHeight = 1800
     * )
     */
    public $pic2;
    
    /**
     * @Assert\Image(
     *     minWidth = 800,
     *     maxWidth = 2200,
     *     minHeight = 600,
     *     maxHeight = 1800
     * )
     */
    public $pic3;
     
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
    	return 'bundles/adclassified/img/annonce';
    }
     
    public function uploadPicture()
    {    
    	// move copie le fichier présent chez le client dans le répertoire indiqué.
    	
    	$this->pic->move($this->getUploadRootDir(), $this->pic->getClientOriginalName());
    	$this->pictureName = $this->pic->getClientOriginalName();
    	
    	if (!is_null($this->pic1)){
    		$this->pic1->move($this->getUploadRootDir(), $this->pic1->getClientOriginalName());
    		$this->pictureName1 = $this->pic1->getClientOriginalName();
    	}
    	if (!is_null($this->pic2)){
    		$this->pic2->move($this->getUploadRootDir(), $this->pic2->getClientOriginalName());
    		$this->pictureName2 = $this->pic2->getClientOriginalName();
    	}
    	if (!is_null($this->pic3)){
    		$this->pic3->move($this->getUploadRootDir(), $this->pic3->getClientOriginalName());
    		$this->pictureName3 = $this->pic3->getClientOriginalName();
    	}
    	
    	// La propriété file ne servira plus
    	$this->pic = null;
    	$this->pic1 = null;
    	$this->pic2 = null;
    	$this->pic3 = null;
    }
    
    public function __construct()
    {
    	$this->attribute = new ArrayCollection();
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

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Ads
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set viewCount
     *
     * @param integer $viewCount
     * @return Ads
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    
        return $this;
    }

    /**
     * Get viewCount
     *
     * @return integer 
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * Set prenium
     *
     * @param integer $prenium
     * @return Ads
     */
    public function setPrenium($prenium)
    {
        $this->prenium = $prenium;
    
        return $this;
    }

    /**
     * Get prenium
     *
     * @return integer 
     */
    public function getPrenium()
    {
        return $this->prenium;
    }
}