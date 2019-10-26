<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Controller\DocumentVlidationRulesController;

/**
 * Custom command class, Entry point to the application
 * collect fileName input from use and send it to controller
 * for further process
 */
class DocumentVlidationRulesCommand extends Command
{
    private $documentVlidationRulesController;

    public function __construct(DocumentVlidationRulesController $documentVlidationRulesController)
    {
        parent::__construct();
        $this->documentVlidationRulesController = $documentVlidationRulesController;
    }

    protected function configure()
    {
        $this
            // the command  name of bin/cpnsole
            ->setName('identification-requests:process')
            // the short description  of command
            ->setDescription('This command validate document requests to provide csv file named input.csv')
            // for help command
            ->setHelp('This command accepts a csv file for the bulk data provided and validate ')
            ->addArgument('fileName', InputArgument::REQUIRED, 'Provide a csv file name to parse which has root directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('fileName');
        // var_dump($fileName);
        //die();
        $this->documentVlidationRulesController->setFileName($fileName);
        $OutputLog = $this->documentVlidationRulesController->process();
        if (!empty($OutputLog)) {
            foreach ($OutputLog as $Output) {
                $output->writeln($Output);
            }
        }
    }
}
