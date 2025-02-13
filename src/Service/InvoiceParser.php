<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Parser\ParserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class InvoiceParser
{
    private EntityManagerInterface $em;
    private array $parsers;

    public function __construct(
        EntityManagerInterface $em,
        iterable $parsers
    ) {
        $this->em = $em;
        $this->parsers = iterator_to_array($parsers);
    }

    public function parse(string $filePath): void
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        // Trouver le parser correspondant
        foreach ($this->parsers as $parser) {
            if (str_contains(strtolower(get_class($parser)), $extension)) {
                $invoices = $parser->parse($filePath);
                $this->saveToDatabase($invoices);
                return;
            }
        }

        throw new Exception("No parser available for file type: $extension");
    }

    private function saveToDatabase(array $invoices): void
    {
        foreach ($invoices as $invoice) {
            print_r($invoice);exit();
            $this->em->getConnection()->executeStatement(
                "UPDATE invoice SET amount = :amount WHERE name = :name",
                ['amount' => $invoice['montant'], 'name' => $invoice['nom']]
            );
        }
    }
}
