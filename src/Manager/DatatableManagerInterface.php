<?php
namespace Avdb\DatatablesBundle\Manager;

use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Exception\DatatableNotFoundException;
use Avdb\DatatablesBundle\Exception\RuntimeException;

/**
 * Interface DatatableManagerInterface
 *
 * @package Avdb\DatatablesBundle\Manager
 */
interface DatatableManagerInterface
{
    /**
     * Checks if the manager has a Datatable with given alias
     *
     * @param string $alias
     * @return bool
     */
    public function has(string $alias): bool;

    /**
     * Returns the Datatable registered with the given alias
     *
     * @param $alias
     * @return DatatableInterface
     * @throws DatatableNotFoundException
     */
    public function get(string $alias): DatatableInterface;

    /**
     * Registers a datatable under its current alias
     *
     * @param string $alias
     * @param DatatableInterface $datatable
     *
     * @throws RuntimeException
     */
    public function add(string $alias, DatatableInterface $datatable): void;
}
