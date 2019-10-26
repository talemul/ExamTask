<?php
namespace App\Controller;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Processor\File\FileProcessor;
use App\Processor\File\CsvParser;
use App\Repository\AppRepositoryManager;
use App\Processor\Validation\ValidationManager;
use App\AppServices;
use App\Utils\FileTypeConstant;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Application controller to handle interaction between different component
 */
class DocumentVlidationRulesController
{
    private $filePath;
    private $fileName;
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function process()
    {
        /* Initialize FileProcessor with filePath, FileName and FileParser
        * Here only CSV fileParser is implemented but we can use it for other
        * file types. All we have to do is implement FileParserInterface.
        */
        $fileProcessor = $this->container->get('csvFileProcessor');
        $fileProcessor->setFilePathInfo($this->filePath, $this->fileName);

        $identityDataList = $fileProcessor->process();

        if (!empty($identityDataList)) {
            $validationManager = $this->container->get('validationManager');
            $validationManager->validate($identityDataList);

            return $this->container->get('appRepositoryManager')->getAppRepository()->getValidationOutputStatusCodeLog();
        }
        
        return array();
    }
}
