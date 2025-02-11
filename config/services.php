<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use App\Service\Parser\JsonParser;
use App\Service\Parser\CsvParser;
use App\Service\InvoiceParser;
use Doctrine\ORM\EntityManagerInterface;

return function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->load('App\\Service\\Parser\\', '../src/Service/Parser/*')
        ->autoconfigure()
        ->autowire()
        ->tag('app.parser');

    $services->set(InvoiceParser::class)
        ->args([
            new Reference(EntityManagerInterface::class),
            new TaggedIteratorArgument('app.parser') 
        ]);
};
