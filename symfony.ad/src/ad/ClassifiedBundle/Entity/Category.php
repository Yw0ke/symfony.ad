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
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
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
     * Add children
     *
     * @param \ad\ClassifiedBundle\Entity\Category $children
     * @return Category
     */
    public function addChild(\ad\ClassifiedBundle\Entity\Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \ad\ClassifiedBundle\Entity\Category $children
     */
    public function removeChild(\ad\ClassifiedBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \ad\ClassifiedBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\ad\ClassifiedBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ad\ClassifiedBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
