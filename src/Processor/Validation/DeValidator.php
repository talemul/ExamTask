<?php
namespace App\Processor\Validation;

use Carbon\Carbon;
use App\Model\DocumentInformation;

/**
 * German validator
 */
class DeValidator extends DocumentValidator
{
    protected function validateExpired(DocumentInformation $documentInformation)
    {
        // 2010-01-01 Germany started to issue new identity card 10 years validity.
        // Checks document type  and set the expire period to 10 years which issued after 2010-01-01
        $newTypeIdentityCardIssueDate = Carbon::createFromFormat('Y-m-d', '2010-01-01');
        if ($documentInformation->isIdentityCard() && $documentInformation->getIssueDate()->greaterThanOrEqualTo($newTypeIdentityCardIssueDate)) {
            $this->expirePeriod->setExpirePeriod(10);
        }
        
        return parent::validateExpired($documentInformation);
    }
}
