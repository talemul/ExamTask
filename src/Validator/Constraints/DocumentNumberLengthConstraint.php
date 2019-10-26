<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use App\Utils\ApplicationConstant;
use App\Processor\Validation\DocumentNumberLength;

/**
 * @Annotation
 */
class DocumentNumberLengthConstraint extends Constraint
{
    protected $documentNumberLength;

    public function __construct(DocumentNumberLength $documentNumberLength)
    {
        $this->documentNumberLength = $documentNumberLength;
    }

    public function getDocumentNumberLength()
    {
        return $this->documentNumberLength;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public $message = ApplicationConstant::ERROR_DOCUMENT_NUMBER_LENGTH_INVALID;
}
