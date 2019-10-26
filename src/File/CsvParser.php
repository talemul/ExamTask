<?php
namespace App\File;

/**
 * CSV file parser, parse the file and return dataset
 */
class CsvParser implements FileParserInterface
{
    public function parse($handle)
    {
        $rows = array();
        while (($data = fgetcsv($handle, null, ",")) !== false) {
            $rows[] = $data;
        }
        
        return $rows;
    }
}
