<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use App\Utils\ApplicationConstant;
use App\Processor\Validation\ExpirePeriod;

/**
 * @Annotation
 */
class DocumentExpiredConstraint extends Constraint
{
    protected $expirePeriod;

    public function __construct(ExpirePeriod $expirePeriod)
    {
        $this->expirePeriod = $expirePeriod;
    }

    public function getExpirePeriod()
    {
        return $this->expirePeriod;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public $message = ApplicationConstant::ERROR_DOCUMENT_IS_EXPIRED;
}
