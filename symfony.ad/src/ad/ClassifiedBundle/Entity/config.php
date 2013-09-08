<?php

namespace ad\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * config
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ad\ClassifiedBundle\Entity\Repository\configRepository")
 */
class config
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
     * @ORM\Column(name="websitePolicy", type="string", length=24)
     */
    private $websitePolicy;

    /**
     * @var array
     *
     * @ORM\Column(name="imageFormat", type="array")
     */
    private $imageFormat;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="resultsByPages", type="integer")
     */
    private $resultsByPages;
    
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
     * Set websitePolicy
     *
     * @param string $websitePolicy
     * @return config
     */
    public function setWebsitePolicy($websitePolicy)
    {
        $this->websitePolicy = $websitePolicy;
    
        return $this;
    }

    /**
     * Get websitePolicy
     *
     * @return string 
     */
    public function getWebsitePolicy()
    {
        return $this->websitePolicy;
    }

    /**
     * Set imageFormat
     *
     * @param array $imageFormat
     * @return config
     */
    public function setImageFormat($imageFormat)
    {
        $this->imageFormat = $imageFormat;
    
        return $this;
    }

    /**
     * Get imageFormat
     *
     * @return array 
     */
    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    /**
     * Set resultsByPages
     *
     * @param integer $resultsByPages
     * @return config
     */
    public function setResultsByPages($resultsByPages)
    {
        $this->resultsByPages = $resultsByPages;
    
        return $this;
    }

    /**
     * Get resultsByPages
     *
     * @return integer 
     */
    public function getResultsByPages()
    {
        return $this->resultsByPages;
    }
}