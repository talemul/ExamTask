<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class DocumentExpiredConstraintValidator extends ConstraintValidator
{
    public function validate($identityInformation, Constraint $constraint)
    {
        // add expire period with document issue date
        $expiredDate = $identityInformation->getIssueDate()->addYear($constraint->getExpirePeriod()->getExpirePeriod());
        
        // checks if expired date greater or equals to verification request date
        // all documents expire 5 years after issue
        if (!$expiredDate->greaterThanOrEqualTo($identityInformation->getRequestDate())) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
