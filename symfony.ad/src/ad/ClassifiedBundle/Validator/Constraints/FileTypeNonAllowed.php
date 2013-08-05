<?php
namespace ad\ExtraBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FileTypeNonAllowed extends Constraint
{
	public $message = 'Le type de fichier "%string%" n\'est pas autorisé';
}