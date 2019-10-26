<?php
namespace App\File;

use Symfony\Component\Finder\Finder;
use App\Utils\FileTypeConstant;

/**
 *
 */
class FileProcessor
{
    private $fileParser;
    private $handle;

    public function __construct(FileParserInterface $fileParser)
    {
        $this->fileParser = $fileParser;
    }

    public function setFilePathInfo($filePath, $fileName)
    {
        if (empty($filePath)) {
            throw new \Exception("NO VALID FILE PATH PROVIDED");
        }

        $finder = new Finder();
        $finder->files()->in($filePath)->name($fileName)->files();
        $fileFound = null;
        foreach ($finder as $file) {
            $fileFound = $file;
        }

        if (empty($fileFound)) {
            throw new \Exception("NO FILE FOUND WITH GIVEN FILE NAME");
        }

        if (($handle = fopen($fileFound->getRealPath(), "r")) !== false) {
            $this->handle = $handle;
        } else {
            throw new \Exception("FILE IS NOT READABLE");
        }
    }

    public function process()
    {
        $data = $this->fileParser->parse($this->handle);
        fclose($this->handle);
        return $data;
    }
}
