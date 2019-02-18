<?php

namespace Avdb\DatatablesBundle\Factory;

use Avdb\DatatablesBundle\DataExtractor\DataExtractorInterface;
use Avdb\DatatablesBundle\DataExtractor\Extraction;
use Avdb\DatatablesBundle\DataExtractor\ExtractionInterface;
use Avdb\DatatablesBundle\Datatable\Datatable;
use Avdb\DatatablesBundle\Datatable\DatatableInterface;
use Avdb\DatatablesBundle\Exception\DataExtractorNotFoundException;
use Avdb\DatatablesBundle\Request\Request;
use Avdb\DatatablesBundle\Request\RequestInterface;
use Avdb\DatatablesBundle\Response\Response;
use Doctrine\Common\Collections\ArrayCollection;

class ResponseFactory
{
    /**
     * @var DataExtractorInterface[]|ArrayCollection
     */
    private $extractors;

    public function __construct()
    {
        $this->extractors = new ArrayCollection();
    }

    public function addExtractor(string $alias, DataExtractorInterface $extractor): void
    {
        $this->extractors->set($alias, $extractor);
    }

    public function createResponse(DatatableInterface $table, RequestInterface $request): Response
    {
        $extractor = $this->getExtractor($table->getAlias());
        $extraction = $extractor->extract($request);

        $output = [];

        foreach ($extraction->getData() as $record) {

            $row = [];

            foreach ($table->getColumns() as $column) {
                $row[] = $column->extractValue($record);

                foreach ($table->getRowOptions() as $option => $extractor) {

                    if ($option === 'class') {
                        $option = 'DT_RowClass';
                    }

                    if ($option === 'id') {
                        $option = 'DT_RowId';
                    }

                    $row[$option] = $extractor($record);
                }
            }

            $output[] = $row;
        }

        return new Response($output, $extraction->getTotalRecords(), $request->getDraw() + 1);
    }

    private function getExtractor(string $alias): DataExtractorInterface
    {
        $extractor = $this->extractors->get($alias);

        if (!$extractor instanceof DataExtractorInterface) {
            throw DataExtractorNotFoundException::fromAlias($alias);
        }

        return $extractor;
    }
}
