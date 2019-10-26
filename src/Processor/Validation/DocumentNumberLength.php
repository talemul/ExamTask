<?php
namespace App\Processor\Validation;

/**
 *
 */
class DocumentNumberLength
{
    
    //document number length rule
    protected $documentNumberLength;

    public function __construct($documentNumberLength)
    {
        $this->documentNumberLength = $documentNumberLength;
    }

    public function setDocumentNumberLength($documentNumberLength)
    {
        $this->documentNumberLength = $documentNumberLength;
    }

    public function getDocumentNumberLenght()
    {
        return $this->documentNumberLength;
    }
}
