<?php

namespace App\Service\Parser;

interface ParserInterface
{
    public function parse(string $filePath): array;
}
