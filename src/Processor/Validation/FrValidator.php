<?php
namespace App\Processor\Validation;

use App\Utils\DocumentTypeConstant;
use App\Model\DocumentInformation;

/**
 * French validator
 */
class FrValidator extends DocumentValidator
{
    protected function validateDocumentIssueDate(DocumentInformation $documentInformation)
    {
        // drivers license allowed any issue date
        if (!$documentInformation->isDriversLicense()) {
            return parent::validateDocumentIssueDate($documentInformation);
        }
        return true;
    }
}
