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
        $data = [];
        $handle = fopen($this->file, 'r');
        $headers = fgetcsv($handle);
        while (($line = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $line);
            $data[] = $row;
        }
        fclose($handle);
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
     * @param string $category
     * @param string $title
     * @param string $description
     * @param float $price
     */
    public function write(string $category, string $title, string $description, float $price)
    {
        $data = [
            $category,
            $title,
            $description,
            $price,
        ];
        $handle = fopen($this->file, 'a');
        fputcsv($handle, $data);
        fclose($handle);
    }
}
