<?php 
namespace Avdb\DatatablesBundle\Request;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Request
 *
 * @package Avdb\DatatablesBundle\Request
 */
class Request implements RequestInterface
{
    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * Default request parameters
     *
     * @var array
     */
    protected $defaults = [
        'order'     => 'desc',
        'sort'      => 'id',
        'page_size' => 10,
    ];

    /**
     * Request constructor.
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return HttpRequest
     */
    public function getHttpRequest()
    {
        return $this->request;
    }

    /**
     * Get Page size from request
     *
     * @return integer
     */
    public function getPageSize()
    {
        return (int)$this->request->query->get('length', $this->defaults['page_size']);
    }

    /**
     * Get page number from request
     *
     * @return int
     */
    public function getPage()
    {
        $offset = $this->request->query->get('start', 0);
        $size = $this->getPageSize();

        return (int)floor($offset / $size) + 1;
    }

    /**
     * Returns the offset of data requested
     * 
     * @return int
     */
    public function getOffset()
    {
        return $this->request->query->get('start', 0);
    }

    /**
     * Extracts the sort parameter from the request object
     *
     * @return string
     */
    public function getSort()
    {
        $order = $this->request->query->get('order', []);
        $columnIndex = isset($order[0]['column']) ? $order[0]['column'] : false;
        $sort = $this->defaults['sort'];

        if (false === $columnIndex) {
            return $sort;
        }

        $columns = $this->request->query->get('columns', []);

        if (isset($columns[$columnIndex]['name'])) {
            $sort = $columns[$columnIndex]['name'];
        }

        return (string)$sort;
    }

    /**
     * Extracts the order parameter from the request object
     *
     * @return string
     */
    public function getOrder()
    {
        $order = $this->request->query->get('order', []);
        return isset($order[0]['dir']) ? $order[0]['dir'] : $this->defaults['order'];
    }

    /**
     * Extracts the search parameter from the request object
     *
     * @return string
     */
    public function getSearch()
    {
        $search = $this->request->query->get('search', []);
        return isset($search['value']) ? $search['value'] : null;
    }

    /**
     * @return int
     */
    public function getDraw()
    {
        return (int)$this->request->query->get('draw', 0);
    }
}
