<?php
namespace App\Service\Parser;

class JsonParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);

        if (!is_array($data)) {
            throw new \Exception("Invalid JSON format in file: $filePath");
        }

        return array_map(fn($invoice) => [
            'name' => $invoice['nom'] ?? '',
            'amount' => (float) ($invoice['montant'] ?? 0)
        ], $data);
    }
}
