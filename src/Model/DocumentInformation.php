<?php
namespace App\Model;

use Carbon\Carbon;
use App\Utils\DocumentTypeConstant;

class DocumentInformation
{
    private $requestDate;
    private $countryCode;
    private $documentType;
    private $documentNumber;
    private $issueDate;
    private $personalIdentificationNumber;
    private $derivedWeeklyRequestLogFindKey;
    private $requestPerWeek;

    public function __construct($requestDate, $countryCode, $documentType, $documentNumber, $issueDate, $personalIdentificationNumber)
    {
        $this->requestDate = Carbon::createFromFormat('Y-m-d', $requestDate)->toImmutable();
        $this->countryCode = $countryCode;
        $this->documentType = $documentType;
        $this->documentNumber = $documentNumber;
        $this->issueDate = Carbon::createFromFormat('Y-m-d', $issueDate)->toImmutable();
        $this->personalIdentificationNumber = $personalIdentificationNumber;
        
        // prepare the logFindKey from identityInformation this is of format
        // week_personalIdentificationNumber
        $this->derivedWeeklyRequestLogFindKey = $this->requestDate->week()."_".$this->personalIdentificationNumber;
    }

    public function getRequestDate()
    {
        return $this->requestDate;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function getDocumentType()
    {
        return $this->documentType;
    }

    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    public function getIssueDate()
    {
        return $this->issueDate;
    }

    public function getPersonalIdentificationNumber()
    {
        return $this->personalIdentificationNumber;
    }

    public function getDerivedWeeklyRequestLogFindKey()
    {
        return $this->derivedWeeklyRequestLogFindKey;
    }

    public function isPassport()
    {
        return $this->documentType === DocumentTypeConstant::PASSPORT;
    }

    public function isDriversLicense()
    {
        return $this->documentType === DocumentTypeConstant::DRIVERS_LICENSE;
    }

    public function isIdentityCard()
    {
        return $this->documentType === DocumentTypeConstant::IDENTITY_CARD;
    }

    public function setRequestPerWeek($requestPerWeek)
    {
        $this->requestPerWeek = $requestPerWeek;
    }

    public function getRequestPerWeek()
    {
        return $this->requestPerWeek;
    }
}
