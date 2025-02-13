<?php
namespace App\Service\Parser;

class JsonParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $content = file_get_contents($filePath);
        return json_decode($content, true);
    }
}
