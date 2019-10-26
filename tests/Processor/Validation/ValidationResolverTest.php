<?php
namespace Test\Processor\Validation;

use PHPUnit\Framework\TestCase;
use App\Processor\Validation\ValidatorResolver;
use App\Repository\AppRepositoryManager;
use App\Model\DocumentInformation;
use App\Processor\Validation\DocumentValidator;
use App\Processor\Validation\DeValidator;
use App\Processor\Validation\ItValidator;
use App\Processor\Validation\FrValidator;
use App\Processor\Validation\EsValidator;
use App\Processor\Validation\PlValidator;
use App\Processor\Validation\UKValidator;

/**
 *
 */
class ValidationResolverTest extends TestCase
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
    public function testResolver($documentInformation, $classType)
    {
        $documentInformation = self::$appRepositoryManager->buildIdentifyInformationObject($documentInformation);

        $validator = ValidatorResolver::resolveValidator($documentInformation);

        $this->assertInstanceOf($classType, $validator);
    }

    public function provider()
    {
        return array(
            array(['2019-01-03','lt','passport','54163812','2019-03-01','357717289'], DocumentValidator::class),
            array(['2019-01-02','de','passport','46530663','2019-03-01','367717289'], DeValidator::class),
            array(['2019-01-04','it','passport','54163813','2019-03-01','387717289'], ItValidator::class),
            array(['2019-01-05','fr','passport','50016230','2019-03-01','327717289'], FrValidator::class),
            array(['2019-01-06','es','passport','17728070','2019-03-01','347717289'], EsValidator::class),
            array(['2019-01-07','pl','passport','67163812','2019-03-01','317717289'], PlValidator::class),
            array(['2019-01-08','uk','passport','59163812','2019-03-01','358817289'], UKValidator::class)
        );
    }
}
