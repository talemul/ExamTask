<?php

use Symfony\Component\DependencyInjection\Reference;

$container->register('csvFileParser', 'App\File\CsvParser');

$container->register('csvFileProcessor', 'App\File\FileProcessor')
    ->addArgument(new Reference('csvFileParser'));

$container->register('appRepositoryManager', 'App\Repository\AppRepositoryManager');

$container->register('validationManager', 'App\Processor\Validation\ValidationManager')
    ->addArgument(new Reference('appRepositoryManager'));
