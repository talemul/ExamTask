<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use App\Utils\ApplicationConstant;
use App\Processor\Validation\AcceptedDocumentTypes;

/**
 * @Annotation
 */
class DocumentTypesConstraint extends Constraint
{
    protected $allowedDocumentTypes;

    public function __construct(AcceptedDocumentTypes $allowedDocumentTypes)
    {
        $this->allowedDocumentTypes = $allowedDocumentTypes;
    }

    public function getAllowedDocumentTypes()
    {
        return $this->allowedDocumentTypes;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public $message = ApplicationConstant::ERROR_DOCUMENT_TYPE_IS_INVALID;
}
