<?php

namespace App\Processor\Validation;

use App\Utils\DocumentTypeConstant;
use Carbon\Carbon;
use App\Model\DocumentInformation;

/**
 * Polish validator
 */
class PlValidator extends DocumentValidator
{
    protected function validateDocumentType(DocumentInformation $documentInformation)
    {
        // Bank of Lithuania decided, than Polish clients may also be identified with residence permits, issued after 2015-06-01.
        // check the issue date after 2015-06-01 allow residence permit as valid document type

        $newPolicyDate = Carbon::createFromFormat('Y-m-d', '2015-06-01');
        if ($documentInformation->getIssueDate()->greaterThan($newPolicyDate)) {
            $this->allowedDocumentTypes->addAllowedDocumentType(DocumentTypeConstant::RESIDENCE_PERMIT);
        }

        return parent::validateDocumentType($documentInformation);
    }

    protected function validateDocumentNumberLength(DocumentInformation $documentInformation)
    {
        // Polish government, starting 2018-09-01, began to issue new identity cards, which have document number length of 10 symbols.
        // Checks if document type identity card and issued from 2018-09-01 then allowed document nuber length 10
        $newPolicyDate = Carbon::createFromFormat('Y-m-d', '2018-09-01');

        if ($documentInformation->isIdentityCard() && $documentInformation->getIssueDate()->greaterThanOrEqualTo($newPolicyDate)) {
            $this->documentNumberLength->setDocumentNumberLength(10);
        }

        return parent::validateDocumentNumberLength($documentInformation);
    }
}
