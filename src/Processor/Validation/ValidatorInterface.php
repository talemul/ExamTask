<?php
namespace App\Processor\Validation;

use App\Model\DocumentInformation;

/**
 * Interface for generic validator
 * different type of validator should implement this interface
 * to get generic behavior from validation manager
 */
interface ValidatorInterface
{
    public function validate(DocumentInformation $documentInformation);
}
