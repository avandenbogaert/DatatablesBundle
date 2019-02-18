<?php
namespace Avdb\DatatablesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'avdb_datatables';
    public const PATH_FACTORY   = '/Datatables/Factory';
    public const PATH_EXTRACTOR = '/Datatables/DataExtractor';
    public const PATH_CONFIG    = '/Resources/config/datatables';
    public const SUFFIX_FACTORY   = 'DatatableFactory.php';
    public const SUFFIX_EXTRACTOR = 'DataExtractor.php';
    public const SUFFIX_CONFIG    = '.datatable.yml';
    public const NAMESPACE_FACTORY   = '%s\Datatables\Factory\%sDatatableFactory';
    public const NAMESPACE_EXTRACTOR = '%s\Datatables\DataExtractor\%sDataExtractor';
    public const DEFINITION_MANAGER = 'avdb_datatables.manager';
    public const DEFINITION_FACTORY = 'avdb_datatables.factory.response';
    public const TAG_TABLE = 'avdb_datatables.table';
    public const TAG_EXTRACTOR = 'avdb_datatables.extractor';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::ROOT_NODE);

        $rootNode->children()
            ->scalarNode('table_template')
            ->defaultValue('@Datatables/Datatables/default_table.html.twig')
            ->end();

        return $treeBuilder;
    }
}
