<?php
namespace App\Processor\Validation;

use App\Repository\AppRepositoryManager;
use App\Model\DocumentInformation;
use App\Utils\ApplicationConstant;

/**
 * This class manages interaction between ValidatorResolved
 * And application repository manager
 * takes identity information list and validate against validator
 */
class ValidationManager
{
    private $appRepositoryManager;
    
    public function __construct(AppRepositoryManager $appRepositoryManager)
    {
        $this->appRepositoryManager = $appRepositoryManager;
    }

    public function validate(array $identityDataList)
    {
        $identityInformation = null;
        $validator = null;

        foreach ($identityDataList as $identityData) {
            // build identity information model object from data as array
            $identityInformation = $this->appRepositoryManager->buildIdentifyInformationObject($identityData);

            // This handle and tracks the single client attempt to
            // identification request per 5 working days
            $this->appRepositoryManager->trackSingleClientRequestPerWeek($identityInformation);

            // resolves validator by identity information and document country code
            $validator = ValidatorResolver::resolveValidator($identityInformation);
            
            // validate identity information provided by calling generic validate method and store the output
            // status code to application repository
            try {
                $outputStatusCode = $validator->validate($identityInformation);
            } catch (\Exception $e) {
                $outputStatusCode = $e->getMessage();
            }
            $this->appRepositoryManager->getAppRepository()->addEntryToValidationOutputStatusCodeLog($outputStatusCode);
        }
    }
}
