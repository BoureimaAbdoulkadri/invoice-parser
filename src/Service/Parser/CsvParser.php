<?php

namespace App\Service\Parser;

class CsvParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $invoices = [];
        if (($handle = fopen($filePath, "r")) !== false) {
            $headers = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $invoices[] = array_combine($headers, $data);
            }
            fclose($handle);
        }
        return $invoices;
    }
}
