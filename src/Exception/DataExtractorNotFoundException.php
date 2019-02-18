<?php
namespace Avdb\DatatablesBundle\Exception;


class DataExtractorNotFoundException extends DatatableNotFoundException
{
    /**
     * Creates a new DatatableNotFoundException from an alias
     *
     * @param $alias
     * @return DatatableNotFoundException
     */
    public static function fromAlias($alias)
    {
        return new self(sprintf(
            'Extractor %s was not registered as a DataExtractor, did you forget to tag the extractor ?',
            $alias
        ));

    }
}