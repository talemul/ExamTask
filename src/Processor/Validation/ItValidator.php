<?php
namespace App\Processor\Validation;

use Carbon\Carbon;
use App\Utils\ApplicationConstant;
use App\Model\DocumentInformation;

/**
 * Italian validator
 */
class ItValidator extends DocumentValidator
{
    protected function validateDocumentIssueDate(DocumentInformation $documentInformation)
    {
        // Italian government decided, that starting from 2019-01-01 document office will be working overtime on Saturdays until 2019-01-31 to cope with increased demand of identity document issue requests.
        // Checks if the document issue date is between 2019-01-01 and 2019-01-31 then allow weekdays and saturday as valid issue date

        $dateRangeStart = Carbon::createFromFormat('Y-m-d', '2019-01-01');
        $dateRangeEnd = Carbon::createFromFormat('Y-m-d', '2019-01-31');
        $issueDate = $documentInformation->getIssueDate();

        if (!$issueDate->isWeekday() && !($issueDate->between($dateRangeStart, $dateRangeEnd) && $issueDate->isSaturday())) {
            throw new \Exception(ApplicationConstant::ERROR_DOCUMENT_ISSUE_DATE_INVALID);
        }
        return true;
    }
}
