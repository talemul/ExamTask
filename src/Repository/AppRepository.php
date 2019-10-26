<?php
namespace App\Repository;

//use App\Model\DocumentInformation;

/**
 *
 */
class AppRepository
{
    private $weeklyRequestPerUserLog = array();
    private $validationOutputStatusCodeLog = array();

    public function getWeeklyRequestPerUserLog()
    {
        return $this->weeklyRequestPerUserLog;
    }

    public function addEntryInWeeklyRequestPerUserLog($Key)
    {
        $this->weeklyRequestPerUserLog[$Key] = 1;
    }

    public function updateEntryInWeeklyRequestPerUserLog($Key)
    {
        $this->weeklyRequestPerUserLog[$Key] += 1;
    }

    public function addEntryToValidationOutputStatusCodeLog($outputCode)
    {
        $this->validationOutputStatusCodeLog[] = $outputCode;
    }

    public function getValidationOutputStatusCodeLog()
    {
        return $this->validationOutputStatusCodeLog;
    }
}
