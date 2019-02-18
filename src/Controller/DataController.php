<?php
namespace Avdb\DatatablesBundle\Controller;

use Avdb\DatatablesBundle\Factory\ResponseFactory;
use Avdb\DatatablesBundle\Manager\DatatableManagerInterface;
use Avdb\DatatablesBundle\Request\Request;
use Avdb\DatatablesBundle\Response\Response;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class DataController
 * Returns the data for each Datatable
 * 
 * @package Avdb\DatatablesBundle\Controller
 */
class DataController
{
    /**
     * @var DatatableManagerInterface
     */
    private $manager;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    public function __construct(DatatableManagerInterface $manager, ResponseFactory $responseFactory)
    {
        $this->manager = $manager;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Generates a page of data for the Datatable
     *
     * @param HttpRequest $request
     * @param $alias
     * @return Response
     */
    public function dataAction(HttpRequest $request, $alias)
    {
        $table = $this->manager->get($alias);

        return $this->responseFactory->createResponse($table, new Request($request));
    }
}
