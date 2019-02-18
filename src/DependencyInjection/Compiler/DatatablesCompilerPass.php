<?php
namespace Avdb\DatatablesBundle\DependencyInjection\Compiler;

use Avdb\DatatablesBundle\DependencyInjection\Configuration;
use Avdb\DatatablesBundle\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the Datatables in the DatatableManager
 * 
 * @package Avdb\DatatablesBundle\DependencyInjection\Compiler
 */
class DatatablesCompilerPass implements CompilerPassInterface
{
    /**
     * Fetches all Datatables and adds them to the DatatableManager
     *
     * @param ContainerBuilder $container
     * @throws RuntimeException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(Configuration::DEFINITION_MANAGER)) {
            throw new RuntimeException(
                'DatatableManager class not found in service configuration. Please check : ' .
                Configuration::DEFINITION_MANAGER
            );
        }

        $manager = $container->findDefinition(Configuration::DEFINITION_MANAGER);
        $tables = $container->findTaggedServiceIds(Configuration::TAG_TABLE);

        foreach ($tables as $id => $tags) {

            foreach($tags as $attributes) {

                if(!isset($attributes['alias']) || empty($attributes['alias'])) {
                    throw new RuntimeException("
                        Error compiling service : '$id'
                        Cannot register table without alias, 
                        please provide the correct alias to the service definition
                    ");
                }

                $manager->addMethodCall('add', [$attributes['alias'], new Reference($id)]);

                // set alias to the datatable
                $tableDefinition = $container->getDefinition($id);
                $tableDefinition->addMethodCall('setAlias', [$attributes['alias']]);
            }
        }
    }
}
