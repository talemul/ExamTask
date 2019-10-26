<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class DocumentTypesConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // checks provided document type is valid document types
        if (!in_array($value, $constraint->getAllowedDocumentTypes()->getAllowedDocumentTypes())) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
