<?php
namespace Test\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use App\Command\DocumentVlidationRulesCommand;
use App\Controller\DocumentVlidationRulesController;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class DocumentVlidationRulesCommandTest extends TestCase
{
    private $documentVlidationRulesControllerMock;

    protected function setUp()
    {
        $this->documentVlidationRulesControllerMock = $this->getMockBuilder(DocumentVlidationRulesController::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testExecute()
    {
        $application = new Application();
        $application->add(new DocumentVlidationRulesCommand($this->documentVlidationRulesControllerMock));

        $command = $application->find('identification-requests:process');
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            array(
            'command'  => $command->getName(),
            'fileName' => 'input.csv')
        );

        $this->assertEquals($commandTester->getStatusCode(), 0);
    }
}
