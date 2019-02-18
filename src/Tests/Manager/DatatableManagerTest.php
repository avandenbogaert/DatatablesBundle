<?php

namespace Avdb\DatatablesBundle\Tests\Manager;

use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Exception\DatatableNotFoundException;
use Avdb\DatatablesBundle\Exception\RuntimeException;
use Avdb\DatatablesBundle\Manager\DatatableManager;
use Avdb\DatatablesBundle\Tests\DatatablesTestCase;

class DatatableManagerTest extends DatatablesTestCase
{
    public function testCanAddDatatable()
    {
        $manager = new DatatableManager();
        $manager->add('mock', $this->mockTable('mock'));

        $this->assertInstanceOf(DatatableInterface::class, $manager->get('mock'));
    }

    public function testHasMethod()
    {
        $manager = new DatatableManager();
        $this->assertFalse($manager->has('some-alias'));
        $manager->add('some-alias', $this->mockTable('some-alias'));
        $this->assertTrue($manager->has('some-alias'));
    }

    public function testShouldThrowExceptionWhenGetIsCalledAndTableNotPresent()
    {
        $manager = new DatatableManager();
        $this->expectException(DatatableNotFoundException::class);
        $manager->get('some-alias');
    }

    public function testReturnsTableWhenGetIsCalled()
    {
        $manager = new DatatableManager();
        $manager->add('mock', $this->mockTable('mock'));
        $this->assertInstanceOf(DatatableInterface::class, $manager->get('mock'));
    }

    public function testThrowsExceptionWhenTableIsAddedTwice()
    {
        $manager = new DatatableManager();
        $table = $this->mockTable('duplicate');

        $manager->add('duplicate', $table);
        $this->expectException(RuntimeException::class);
        $manager->add('duplicate', $table);
    }
}
