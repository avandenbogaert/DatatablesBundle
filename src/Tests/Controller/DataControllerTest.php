<?php

namespace Avdb\DatatablesBundle\Tests\Controller;

use Avdb\DatatablesBundle\Controller\DataController;
use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Factory\ResponseFactory;
use Avdb\DatatablesBundle\Manager\DatatableManagerInterface;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Tests\DatatablesTestCase;
use Avdb\DatatablesBundle\Response\Response;
use Symfony\Component\HttpFoundation\Request;

class DataControllerTest extends DatatablesTestCase
{
    public function testIsInitializable()
    {
        /** @var DatatableManagerInterface $manager */
        $manager = $this->getMockObject(DatatableManagerInterface::class);
        $factory = $this->getMockObject(ResponseFactory::class);

        $controller = new DataController($manager, $factory);
        $this->assertInstanceOf(DataController::class, $controller);
    }

    public function testReturnsResponseWhenTableIsFound()
    {
        $request = $this->getMockObject(Request::class);

        $table = $this->getMockObject(DatatableInterface::class);
        $table->method('getAlias')->willReturn('mocktable');

        $factory = $this->getMockObject(ResponseFactory::class);
        $factory->method('createResponse')->with($table, $this->isInstanceOf(RequestInterface::class))->willReturn(new Response([], 10, 1));

        /** @var DatatableInterface $table */

        $manager = $this->getMockObject(DatatableManagerInterface::class);
        $manager
            ->method('has')
            ->with('mocktable')
            ->willReturn(true);

        $manager
            ->method('get')
            ->with('mocktable')
            ->willReturn($table);

        /** @var DatatableManagerInterface $manager */

        $controller = new DataController($manager, $factory);

        $this->assertInstanceOf(Response::class, $controller->dataAction($request, 'mocktable'));
    }
}
