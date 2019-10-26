<?php
namespace App\File;

/**
 * Interface for generic file parse
 * different type of file parse should implement this interface
 * to get generic behavior from controller
 */
interface FileParserInterface
{
    public function parse($handle);
}
