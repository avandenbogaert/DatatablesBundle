<?php

namespace Avdb\DatatablesBundle\Tests\Datatable;

use Avdb\DatatablesBundle\Column\Column;
use Avdb\DatatablesBundle\Column\ColumnInterface;
use Avdb\DatatablesBundle\DataExtractor\DataExtractorInterface;
use Avdb\DatatablesBundle\DataExtractor\Extraction;
use Avdb\DatatablesBundle\Datatable\Datatable;
use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Exception\RuntimeException;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Response\Response;
use Avdb\DatatablesBundle\Tests\DatatablesTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class DatatableTest extends DatatablesTestCase
{
    public function testIsInitializable()
    {
        $table = new Datatable();
        $this->assertInstanceOf(DatatableInterface::class, $table);
    }

    public function testCanAddColumns()
    {
        $table = new Datatable();

        $this->assertCount(0, $table->getColumns());

        $table->addColumn(new Column('name'));

        $this->assertCount(1, $table->getColumns());
    }

    public function testCanCreateColumns()
    {
        $table = new Datatable();

        $this->assertCount(0, $table->getColumns());

        $table->createColumn('test');
        $table->createColumn('name');

        $this->assertInstancesOf(ColumnInterface::class, $table->getColumns());
    }

    public function testCanAddRequestParam()
    {
        $table = new Datatable();
        $table->setRequestParam('some', 'bar');

        $this->assertEquals('bar', $table->getRequestParams()['some']);
    }
}
