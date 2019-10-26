<?php
namespace App\Processor\Validation;

/**
 *
 */
class AcceptedDocumentTypes
{
    //allowed document types
    private $allowedDocumentTypes;

    public function __construct(array $allowedDocumentTypes)
    {
        $this->allowedDocumentTypes = $allowedDocumentTypes;
    }

    public function getAllowedDocumentTypes()
    {
        return $this->allowedDocumentTypes;
    }

    public function addAllowedDocumentType($allowedDocumentType)
    {
        $this->allowedDocumentTypes[] = $allowedDocumentType;
    }

    public function resetAllowedDocumentTypes(array $allowedDocumentTypes)
    {
        $this->allowedDocumentTypes = $allowedDocumentTypes;
    }
}
