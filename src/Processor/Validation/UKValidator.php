<?php
namespace App\Processor\Validation;

use Carbon\Carbon;
use App\Utils\DocumentTypeConstant;
use App\Model\DocumentInformation;

/**
 * UK validator
 */
class UKValidator extends DocumentValidator
{
    protected function validateDocumentType(DocumentInformation $documentInformation)
    {
        // Due to UK leaving european union, after 2019-01-01 only passports will be accepted as proof of identity from UK clients.
        // Checks the document validation is requested after 2019-01-01 then only accepting passport as document allowed type
        $newPolicyDate = Carbon::createFromFormat('Y-m-d', '2019-01-01');
        if ($documentInformation->getRequestDate()->greaterThan($newPolicyDate)) {
            // reset allowed document types
            $this->allowedDocumentTypes->resetAllowedDocumentTypes([DocumentTypeConstant::PASSPORT]);
        }

        return parent::validateDocumentType($documentInformation);
    }
}
