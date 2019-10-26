<?php
namespace Test\Repository;

use PHPUnit\Framework\TestCase;
use App\Repository\AppRepository;
use App\Repository\AppRepositoryManager;
use App\Model\DocumentInformation;

/**
 *
 */
class AppRepositoryManagerTest extends TestCase
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

    public function testGetAppRepository()
    {
        $this->assertInstanceOf(AppRepository::class, self::$appRepositoryManager->getAppRepository());
    }

    public function testBuildIdentifyInformationObject()
    {
        $this->assertInstanceOf(DocumentInformation::class, self::$appRepositoryManager->buildIdentifyInformationObject(['2019-01-03','lt','passport','54163812','2019-03-01','357717289']));
    }

    public function testFindWeeklyRequestPerUserLog()
    {
        $logFindKey = '1_1';

        $logEntry = self::$appRepositoryManager->findWeeklyRequestPerUserLog($logFindKey);
        $this->assertEmpty($logEntry);

        self::$appRepositoryManager->getAppRepository()->addEntryInWeeklyRequestPerUserLog($logFindKey);

        $logEntry = self::$appRepositoryManager->findWeeklyRequestPerUserLog($logFindKey);
        $this->assertEquals(1, $logEntry[$logFindKey]);

        self::$appRepositoryManager->getAppRepository()->updateEntryInWeeklyRequestPerUserLog($logFindKey);

        $logEntry = self::$appRepositoryManager->findWeeklyRequestPerUserLog($logFindKey);
        $this->assertEquals(2, $logEntry[$logFindKey]);
    }
}
