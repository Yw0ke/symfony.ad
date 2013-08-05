<?php
namespace ad\ExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FileTypeNonAllowedValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{	
		if ($value != null)
		{
			if (strpos($value->getClientOriginalName(), '.exe')) {
				$this->context->addViolation($constraint->message, array('%string%' => $value->getClientOriginalName()));
			}
		}
	}
}