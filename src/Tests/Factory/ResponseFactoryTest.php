<?php
namespace Avdb\DatatablesBundle\Tests\Factory;

use Avdb\DatatablesBundle\Column\ColumnInterface;
use Avdb\DatatablesBundle\DataExtractor\DataExtractorInterface;
use Avdb\DatatablesBundle\DataExtractor\Extraction;
use Avdb\DatatablesBundle\Datatable\Datatable;
use Avdb\DatatablesBundle\Factory\ResponseFactory;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Response\Response;
use Avdb\DatatablesBundle\Tests\DatatablesTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactoryTest extends DatatablesTestCase
{
    public function testCanCreateResponse()
    {
        $extractor = $this->getMockObject(DataExtractorInterface::class);
        $column    = $this->getMockObject(ColumnInterface::class);
        $request   = $this->getMockObject(RequestInterface::class);

        $extractor
            ->method('extract')
            ->willReturn(new Extraction([new \stdClass()], 1));

        $column
            ->method('extractValue')
            ->willReturn('some-value');

        $request
            ->method('getDraw')
            ->willReturn(0);

        $table = new Datatable();
        $table->addColumn($column);
        $table->setAlias('mocktable');

        $factory = new ResponseFactory();
        $factory->addExtractor('mocktable', $extractor);

        $response = $factory->createResponse($table, $request);

        $this->assertContains('some-value', $response->getContent());
    }
}