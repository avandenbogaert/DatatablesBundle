<?php
namespace Avdb\DatatablesBundle\Datatable;

use Avdb\DatatablesBundle\Column\ColumnInterface;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Response\Response;

/**
 * Interface DatatableInterface
 *
 * @package Avdb\DatatablesBundle\Datatable
 */
interface DatatableInterface
{
    /**
     * The extra HTML-class attribute the table will receive
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * @param string $class
     */
    public function setClass(string $class): void;

    /**
     * Adds a Column element to the DataTable's columns
     *
     * @param ColumnInterface $column
     * @return DataTableInterface
     */
    public function addColumn(ColumnInterface $column): DatatableInterface;

    /**
     * @param string $name
     * @param \closure $function
     * @return DatatableInterface
     */
    public function addRowOption(string $name, \closure $function): DatatableInterface;

    /**
     * @return array|\Closure[]
     */
    public function getRowOptions(): array;

    /**
     * Sets an option, passed to the javascript options array used by DataTables.net
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setOption(string $name, $value): void;

    /**
     * Set a value that will be sent to the DataExtractor as a request parameter
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setRequestParam(string $name, $value): void;

    /**
     * @return array
     */
    public function getRequestParams(): array;

    /**
     * Returns an array of options
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Creates a Column element and adds it tho the DataTable's columns
     *
     * @param string $name
     * @param array $options
     * @return DataTableInterface
     */
    public function createColumn(string $name, array $options = []): DatatableInterface;

    /**
     * Returns all columns that are present in the table
     *
     * @return array|ColumnInterface[]
     */
    public function getColumns(): array;

    /**
     * Returns the alias of the table for which it is registered in the manager
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * @param string $alias
     * @internal This value is set through the DatatableCompilerPass and should not be set manually.
     */
    public function setAlias(string $alias): void;
}
