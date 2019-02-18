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

    public function __construct()
    {
        $this->columns = [];
    }

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @inheritDoc
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    public function setOption(string $name, $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function setRequestParam(string $name, $value): void
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
     * @inheritdoc
     */
    public function getRowOptions(): array
    {
        return $this->rowOptions;
    }

    /**
     * @inheritDoc
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function addColumn(ColumnInterface $column): DatatableInterface
    {
        $this->columns[$column->getName()] = $column;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function createColumn(string $name, array $options = []): DatatableInterface
    {
        return $this->addColumn(new Column($name, $options));
    }

    /**
     * @inheritDoc
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }
}
