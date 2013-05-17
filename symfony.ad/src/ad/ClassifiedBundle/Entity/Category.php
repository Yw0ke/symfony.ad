<?php

namespace ad\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping\Column;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ad\ClassifiedBundle\Entity\Repository\CategoryRepository")
 */
class Category
{
	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=42)
	 */
	private $name;
	
 	/**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="cascade")
     */
    private $parent;
	
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
     * Set name
     * 
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Parent
     *
     * @var array
     * 
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
		
        return $this;
    }
    
    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Get children
     * 
     * @return array
     */
    public function getChildren()
    {
    	return $this->children;
    }
    
    /**
     * Set children
     *
     * @param array $children
     * @return Category
     */
    public function setChildren($children)
    {
    	$this->children = $children;
    
    	return $this;
    }
}
