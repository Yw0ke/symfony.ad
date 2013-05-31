<?php
namespace ad\ClassifiedBundle\Form;

class AdsParameter {
	protected $data;
	public function __construct($attribute,$edit=false)
	{
		if ($edit==false) {
			foreach ($attribute as $k => $value) {
				$name = $value->getAttributeId()->getName();
				$this->data[$name] = array("label"=>$name,"value"=>"");
				$this->{$name} = "";
			}
		} else {
			foreach ($attribute as $k => $value) {
				$name = $value->getAttributeId()->getName();
				$pvalue = $value->getValue();
				$this->data[$name] = array("label"=>$name,"value"=>$pvalue);
				$this->{$name} = $pvalue;
			}
		}
	}
	public function get() { return $this->data; }
}