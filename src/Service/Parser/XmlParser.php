<?php

namespace App\Service\Parser;

use App\Service\Parser\ParserInterface;
use RuntimeException;
use SimpleXMLElement;

class XmlParser implements ParserInterface
{
    public function parse(string $content): array
    {
        if (empty($content)) {
            return [];
        }

        $xml = simplexml_load_string($content);
        if ($xml === false) {
            throw new RuntimeException('Erreur lors du parsing XML');
        }

        return json_decode(json_encode($xml), true);
    }

    public function encode(array $data): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root></root>');
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private function arrayToXml(array $data, SimpleXMLElement &$xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
    }
}
