<?php

declare(strict_types=1);


namespace App\Command;

use App\Service\InvoiceParser;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:parse')]
class ParseInvoicesCommand extends Command
{
    private InvoiceParser $parser;

    public function __construct(InvoiceParser $parser)
    {
        parent::__construct();
        $this->parser = $parser;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln('Début du traitement des factures...');

            $output->writeln('Traitement du fichier JSON...');
            $this->parser->parse('data/invoices.json');

            $output->writeln('Traitement du fichier CSV...');
            $this->parser->parse('data/invoices.csv');

            $output->writeln('Traitement du fichier XML...');
            $this->parser->parse('data/invoices.xml');

            $output->writeln('Traitement terminé avec succès.');
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('<error>Une erreur : ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
