<?php
namespace Avdb\DatatablesBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Exception\DatatableNotFoundException;
use Avdb\DatatablesBundle\Exception\RuntimeException;

/**
 * Class DatatableManager
 * DatatableManager holds all the Datatables
 * 
 * @package Avdb\DatatablesBundle\Manager
 */
class DatatableManager implements DatatableManagerInterface
{
    /**
     * @var ArrayCollection|DatatableInterface[]
     */
    private $datatables;

    /**
     * DatatableManager constructor.
     */
    public function __construct()
    {
        $this->datatables = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function has(string $alias): bool
    {
        return $this->datatables->get($alias) instanceof DatatableInterface;
    }

    /**
     * @inheritdoc
     */
    public function get(string $alias): DatatableInterface
    {
        if (true !== $this->has($alias)) {
            throw DatatableNotFoundException::fromAlias($alias);
        }

        return $this->datatables->get($alias);
    }

    /**
     * @inheritdoc
     */
    public function add(string $alias, DatatableInterface $datatable): void
    {
        if (true === $this->has($alias)) {
            throw new RuntimeException(
                "Datatable {$alias} is already registered, cannot register a table twice"
            );
        }

        $this->datatables->set($alias, $datatable);
    }
}
