<?php
namespace Avdb\DatatablesBundle\Request;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Interface RequestInterface
 *
 * @package Avdb\DatatablesBundle\Request
 */
interface RequestInterface
{
    /**
     * @return HttpRequest
     */
    public function getHttpRequest(): HttpRequest;

    /**
     * Get the request param passed through the datatable
     *
     * @param string $name
     * @return mixed
     */
    public function getRequestParam(string $name) :?string;

    /**
     * Get Page size from request
     *
     * @param null|string $default
     * @return integer
     */
    public function getPageSize($default = null): int;

    /**
     * Get page number from request
     *
     * @return int
     */
    public function getPage(): int;

    /**
     * Returns the offset, if this is preferred above getPage
     * 
     * @return int
     */
    public function getOffset(): int;

    /**
     * Extracts the sort parameter from the request object
     *
     * @param null|string $default
     * @return string
     */
    public function getSort($default = null): ?string;

    /**
     * Extracts the order parameter from the request object
     *
     * @param null|string $default
     * @return string
     */
    public function getOrder($default = null): ?string;

    /**
     * Extracts the search parameter from the request object
     *
     * @return string
     */
    public function getSearch(): ?string;

    /**
     * @return int
     */
    public function getDraw(): int;
}
