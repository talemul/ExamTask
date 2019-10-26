<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class DocumentNumberLengthConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // check document number length
        if (strlen($value) !== $constraint->getDocumentNumberLength()->getDocumentNumberLenght()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
