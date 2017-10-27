<?php

namespace App\Util;

/**
 * Class CsvReader
 */
class CsvReader
{
    private $file;

    /**
     * CsvReader constructor.
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Reads the csv file and returns the required category.
     *
     * @param string $category
     * @return array $data
     */
    public function read(string $category): array
    {
        $data = $this->readAll();
        foreach ($data as $key => $record) {
            if ($record['kategorie'] != $category) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * Write new line into csv file.
     *
     * @param array $data
     */
    public function write(array $data)
    {
        $handle = fopen($this->file, 'a');
        fputcsv($handle, $data);
        fclose($handle);
    }

    /**
     * Read all data.
     *
     * @return array
     */
    public function readAll(): array
    {
        $data = [];
        $handle = fopen($this->file, 'r');
        $headers = fgetcsv($handle);
        while (($line = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $line);
            $data[] = $row;
        }
        fclose($handle);
        return $data;
    }
}
