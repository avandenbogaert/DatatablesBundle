<?php
namespace Avdb\DatatablesBundle\Datatable;

use Avdb\DatatablesBundle\Column\Column;
use Avdb\DatatablesBundle\Column\ColumnInterface;
use Avdb\DatatablesBundle\DataExtractor\DataExtractorInterface;
use Avdb\DatatablesBundle\DataExtractor\ExtractionInterface;
use Avdb\DatatablesBundle\Exception\RuntimeException;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Response\Response;

/**
 * Class Datatable
 *
 * @package Avdb\DatatablesBundle\Datatable
 */
class Datatable implements DatatableInterface
{
    public const CLASS_TABLE_STRIPED = 'table-striped';

    /**
     * @var DataExtractorInterface
     */
    private $extractor;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var array|ColumnInterface[]
     */
    private $columns;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $requestParams = [];

    /**
     * @var array
     */
    private $rowOptions = [];

    /**
     * @var string
     */
    private $class = '';

    /**
     * Datatable constructor.
     *
     * @param string $alias
     * @param DataExtractorInterface $extractor
     */
    public function __construct($alias, DataExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
        $this->alias = $alias;
        $this->columns = [];
    }

    /**
     * Generates the correct API-response for the DataTable,
     * should be indulged into a JSONResponse Object by the controller
     *
     * @param RequestInterface $request
     * @return Response
     * @throws RuntimeException
     */
    public function buildResponse(RequestInterface $request): Response
    {
        $result = $this->extractor->extract($request);

        if(!$result instanceof ExtractionInterface) {
            throw new RuntimeException(
                'Expected instanceof ExtractionInterface from DataExtractor  (' . get_class($this->extractor) . ').'
            );
        }

        $data = [];

        foreach ($result->getData() as $target) {

            $row = [];
            
            foreach ($this->columns as $column) {

                $row[] = $column->extractValue($target);

                foreach ($this->rowOptions as $name => $extractor) {

                    if ($name === 'class') {
                        $name = 'DT_RowClass';
                    }

                    if ($name === 'id') {
                        $name = 'DT_RowId';
                    }

                    $row[$name] = $extractor($target);
                }
            }

            $data[] = $row;
        }

        return new Response($data, $result->getTotalRecords(), $request->getDraw() + 1);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    public function setOption($name, $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function setRequestParam($name, $value): void
    {
        $this->requestParams[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function addRowOption(string $name, \closure $function): DatatableInterface
    {
        $this->rowOptions[$name] = $function;
        return $this;
    }

    /**
     * @return array
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Adds a Column element to the DataTable's columns
     *
     * @param ColumnInterface $column
     * @return DataTableInterface
     */
    public function addColumn(ColumnInterface $column): DatatableInterface
    {
        $this->columns[$column->getName()] = $column;
        return $this;
    }

    /**
     * Creates a Column element and adds it tho the DataTable's columns
     *
     * @param string $name
     * @param array $options
     * @return DataTableInterface
     */
    public function createColumn($name, array $options = []): DatatableInterface
    {
        return $this->addColumn(new Column($name, $options));
    }

    /**
     * Returns all columns that are present in the table
     *
     * @return array|ColumnInterface[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Returns the alias of the table for which it is registered in the manager
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
}
