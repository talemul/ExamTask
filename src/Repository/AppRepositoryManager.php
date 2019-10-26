<?php
namespace App\Repository;

use App\Model\DocumentInformation;

class AppRepositoryManager
{
    private $appRepository;

    public function __construct()
    {
        $this->appRepository = new AppRepository();
    }

    public function getAppRepository()
    {
        return $this->appRepository;
    }

    /**
    * build DocumentInformation object from provided array data and returns the object
    */
    public function buildIdentifyInformationObject(array $data)
    {
        return new DocumentInformation($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
    }

    /**
    * search the application repository for entries with key provided
    * and return the log entry if found
    */
    public function findWeeklyRequestPerUserLog($logFindkey)
    {
        $allowed  = [$logFindkey];
        $filtered = array_filter(
            $this->appRepository->getWeeklyRequestPerUserLog(),
            function ($key) use ($allowed) {
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $filtered;
    }

    /**
    * This method handle and tracks the single client attempt to
    * identification request per 5 working days
    */
    public function trackSingleClientRequestPerWeek(DocumentInformation $documentInformation)
    {
        // get the logFindKey from identityInformation this is of format
        // week_personalIdentificationNumber
        $logFindKey = $documentInformation->getDerivedWeeklyRequestLogFindKey();

        // search the application repository for entries with key provided
        $logEntry = $this->findWeeklyRequestPerUserLog($logFindKey);

        if (empty($logEntry)) {
            // if no entry found put entry to log for tracking
            $this->appRepository->addEntryInWeeklyRequestPerUserLog($logFindKey);
        } else {
            // increment the request attempt
            $this->appRepository->updateEntryInWeeklyRequestPerUserLog($logFindKey);
        }

        $logEntry = $this->findWeeklyRequestPerUserLog($logFindKey);
        $documentInformation->setRequestPerWeek($logEntry[$logFindKey]);

        return $logEntry;
    }
}
