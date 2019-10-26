<?php
namespace Test\Processor\Validation;

use PHPUnit\Framework\TestCase;
use App\Repository\AppRepositoryManager;
use App\Model\DocumentInformation;
use App\Processor\Validation\ValidatorResolver;
use App\Processor\Validation\DocumentValidator;
use App\Utils\ApplicationConstant;

/**
 *
 */
class BaseValidatorTest extends TestCase
{
    private static $appRepositoryManager;
    
    public static function setUpBeforeClass()
    {
        self::$appRepositoryManager = new AppRepositoryManager();
    }

    public static function tearDownAfterClass()
    {
        self::$appRepositoryManager = null;
    }

    /**
    * @dataProvider provider
    */
    public function testBaseValidator($documentInformation, $statusCode)
    {
        $documentInformation = self::$appRepositoryManager->buildIdentifyInformationObject($documentInformation);

        self::$appRepositoryManager->trackSingleClientRequestPerWeek($documentInformation);

        $validator = ValidatorResolver::resolveValidator($documentInformation);

        try {
            $this->assertEquals($statusCode, $validator->validate($documentInformation));
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), $statusCode);
        }
    }

    public function provider()
    {
        return array(
            array(['2019-01-01','lt','passport','30122719','2019-03-01','357717289'], ApplicationConstant::VALID),
            array(['2019-01-02','lt','drivers_license','46530663','2019-03-01','357717289'], ApplicationConstant::ERROR_DOCUMENT_TYPE_IS_INVALID),
            array(['2019-01-03','lt','passport','54163812','2019-03-01','357717289'], ApplicationConstant::ERROR_REQUEST_LIMIT_EXCEEDED),
            array(['2019-01-08','lt','passport','54163812','2013-03-01','357717289'], ApplicationConstant::ERROR_DOCUMENT_IS_EXPIRED),
            array(['2019-01-09','lt','passport','541638121','2019-03-01','357717289'], ApplicationConstant::ERROR_DOCUMENT_NUMBER_LENGTH_INVALID),
            array(['2019-01-17','lt','passport','54163812','2019-01-12','357717289'], ApplicationConstant::ERROR_DOCUMENT_ISSUE_DATE_INVALID)
        );
    }
}
