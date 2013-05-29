<?php

namespace ad\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * attributeValues
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ad\ClassifiedBundle\Entity\Repository\attributeValuesRepository")
 */
class attributeValues
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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ad\ClassifiedBundle\Entity\attribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=false)
     */
    private $attributeId;
    
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ad\ClassifiedBundle\Entity\Ads")
     * @ORM\JoinColumn(name="Ads_id", referencedColumnName="id", nullable=false)
     */
    private $AdsId;

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
     * Set value
     *
     * @param string $value
     * @return attributeValues
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set attributeId
     *
     * @param \ad\ClassifiedBundle\Entity\attribute $attributeId
     * @return attributeValues
     */
    public function setAttributeId(\ad\ClassifiedBundle\Entity\attribute $attributeId)
    {
        $this->attributeId = $attributeId;

        return $this;
    }

    /**
     * Get attributeId
     *
     * @return \ad\ClassifiedBundle\Entity\attribute 
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * Set AdsId
     *
     * @param \ad\ClassifiedBundle\Entity\Ads $adsId
     * @return attributeValues
     */
    public function setAdsId(\ad\ClassifiedBundle\Entity\Ads $adsId)
    {
        $this->AdsId = $adsId;

        return $this;
    }

    /**
     * Get AdsId
     *
     * @return \ad\ClassifiedBundle\Entity\Ads 
     */
    public function getAdsId()
    {
        return $this->AdsId;
    }
}
