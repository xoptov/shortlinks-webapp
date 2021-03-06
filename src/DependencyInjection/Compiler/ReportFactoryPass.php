<?php

namespace App\DependencyInjection\Compiler;

use App\Reports\Factory\ReportFactory;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ReportFactoryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(ReportFactory::class)) {
            return;
        }

        $reportFactoryDefinition = $container->getDefinition(
            ReportFactory::class
        );

         $taggedServices = $container->findTaggedServiceIds('report.data_loader');

        foreach ($taggedServices as $id => $tags) {
            $reportFactoryDefinition->addMethodCall(
                'registerDataLoader',
                [new Reference($id)]
            );
        }
    }
}