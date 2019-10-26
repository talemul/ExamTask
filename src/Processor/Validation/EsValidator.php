<?php

namespace App\Processor\Validation;

use Carbon\Carbon;
use App\Utils\ApplicationConstant;
use App\Utils\AppUtils;
use App\Utils\DocumentTypeConstant;
use App\Model\DocumentInformation;

/**
 * Spanish  validator
 */
class EsValidator extends DocumentValidator
{
    protected function validateDocumentNumber(DocumentInformation $documentInformation)
    {

        // Spanish passports serial numbers from 50001111 to 50009999 where stolen and no longer may be used for client identification.
        //  if document type is passport and document number in range then it is invalid, valid otherwise
        $documentNumber = intval($documentInformation->getDocumentNumber());
        $options = array('min_range' => 50001111,
            'max_range' => 50009999);

        if ($documentInformation->isPassport() && !empty(AppUtils::filter_integer_variable($documentNumber, $options))) {
            throw new \Exception(ApplicationConstant::ERROR_DOCUMENT_NUMBER_INVALID);
        }

        return true;
    }

    protected function validateExpired(DocumentInformation $documentInformation)
    {
        // 2013-02-14 Spain  started to issue new identity card 15 years validity.
        // Checks document type  and set the expire period to 15 years which issued after 2013-02-14
        $newTypePassportIssueDate = Carbon::createFromFormat('Y-m-d', '2013-02-14');
        if ($documentInformation->isPassport() && $documentInformation->getIssueDate()->greaterThanOrEqualTo($newTypePassportIssueDate)) {
            $this->expirePeriod->setExpirePeriod(15);
        }

        return parent::validateExpired($documentInformation);
    }
}
