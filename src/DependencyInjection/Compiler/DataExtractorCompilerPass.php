<?php

namespace Avdb\DatatablesBundle\DependencyInjection\Compiler;

use Avdb\DatatablesBundle\DependencyInjection\Configuration;
use Avdb\DatatablesBundle\Exception\RuntimeException;
use Avdb\DatatablesBundle\Factory\ResponseFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the DataExtractors to the ResponseFactory class
 *
 * @package Avdb\DatatablesBundle\DependencyInjection\Compiler
 */
class DataExtractorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(Configuration::DEFINITION_FACTORY)) {
            throw new RuntimeException(
                ResponseFactory::class . ' not found in service configuration. Please check : ' .
                Configuration::DEFINITION_FACTORY
            );
        }

        $factory = $container->findDefinition(Configuration::DEFINITION_FACTORY);
        $extractors = $container->findTaggedServiceIds(Configuration::TAG_EXTRACTOR);

        foreach ($extractors as $id => $tags) {
            foreach ($tags as $attributes) {

                if (!isset($attributes['alias']) || empty($attributes['alias'])) {
                    throw new RuntimeException("
                        Error compiling service : '$id'
                        Cannot register data extractor without alias, 
                        please provide the correct alias to the service definition
                    ");
                }

                $factory->addMethodCall('addExtractor', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}