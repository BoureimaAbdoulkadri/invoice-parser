<?php

namespace App\Service\Parser;

class CsvParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $rows = array_map('str_getcsv', file($filePath));
        $invoices = [];

        foreach ($rows as $row) {
            if (count($row) < 3) {
                continue; // Skip invalid rows
            }

            $invoices[] = [
                'name' => trim($row[2]),
                'amount' => (float) trim($row[0])
            ];
        }

        return $invoices;
    }
}
