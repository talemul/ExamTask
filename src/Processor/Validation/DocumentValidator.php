<?php
namespace App\Processor\Validation;

use App\Model\DocumentInformation;
use App\Utils\ApplicationConstant;
use App\Validator\Constraints\DocumentNumberLengthConstraint;
use App\Utils\AppUtils;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use App\Validator\Constraints\DocumentExpiredConstraint;
use App\Validator\Constraints\DocumentTypesConstraint;

/**
 * Generic validator all countries
 */
class DocumentValidator implements ValidatorInterface
{
    //document types rule
    protected $allowedDocumentTypes;
    //expire period rule
    protected $expirePeriod;
    //document length rule
    protected $documentNumberLength;

    protected $validator;

    public function __construct(AcceptedDocumentTypes $allowedDocumentTypes, ExpirePeriod $expirePeriod, DocumentNumberLength $documentNumberLength, RecursiveValidator $validator)
    {
        $this->allowedDocumentTypes = $allowedDocumentTypes;
        $this->expirePeriod = $expirePeriod;
        $this->documentNumberLength = $documentNumberLength;
        $this->validator = $validator;
    }

    /**
    * Validate limit rules
    */
    protected function validateRequestLimit(DocumentInformation $documentInformation)
    {
        // single client may only attempt two request per 5 working days
        if ($documentInformation->getRequestPerWeek() > 2) {
            throw new \Exception(ApplicationConstant::ERROR_REQUEST_LIMIT_EXCEEDED);
        }

        return true;
    }

    /**
    * Validate type rules
    */
    protected function validateDocumentType(DocumentInformation $documentInformation)
    {
        $violations = $this->validator->validate($documentInformation->getDocumentType(), new DocumentTypesConstraint($this->allowedDocumentTypes));

        if (count($violations) > 0) {
            throw new \Exception(AppUtils::buildMessageFromConstraintViolationList($violations));
        }

        return true;
    }

    /**
    * Validate expire rules
    */
    protected function validateExpired(DocumentInformation $documentInformation)
    {
        $violations = $this->validator->validate($documentInformation, new DocumentExpiredConstraint($this->expirePeriod));

        if (count($violations) > 0) {
            throw new \Exception(AppUtils::buildMessageFromConstraintViolationList($violations));
        }

        return true;
    }

    /**
    * Validate number length rules
    */
    protected function validateDocumentNumberLength(DocumentInformation $documentInformation)
    {
        // checkes with allowed document length
        // all documents have document number consisting of 8 symbols
        
        $violations = $this->validator->validate($documentInformation->getDocumentNumber(), new DocumentNumberLengthConstraint($this->documentNumberLength));

        if (count($violations) > 0) {
            throw new \Exception(AppUtils::buildMessageFromConstraintViolationList($violations));
        }

        return true;
    }

    /**
    * Validate number rules
    */
    protected function validateDocumentNumber(DocumentInformation $documentInformation)
    {
        return true;
    }

    /**
    * Validate issue date rules
    */
    protected function validateDocumentIssueDate(DocumentInformation $documentInformation)
    {
        // issued on workday (Monday to Friday)
        if (!$documentInformation->getIssueDate()->isWeekday()) {
            throw new \Exception(ApplicationConstant::ERROR_DOCUMENT_ISSUE_DATE_INVALID);
        }
        return true;
    }

    /**
    * checks all validation and return the validation status code
    */
    public function validate(DocumentInformation $documentInformation)
    {
        $this->validateRequestLimit($documentInformation)
        && $this->validateDocumentType($documentInformation)
        && $this->validateExpired($documentInformation)
        && $this->validateDocumentNumberLength($documentInformation)
        && $this->validateDocumentNumber($documentInformation)
        && $this->validateDocumentIssueDate($documentInformation);

        return ApplicationConstant::VALID;
    }
}
