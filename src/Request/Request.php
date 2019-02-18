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
    protected static $defaults = [
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
     * @inheritdoc
     */
    public function getHttpRequest(): HttpRequest
    {
        return $this->request;
    }

    /**
     * @inheritdoc
     */
    public function getRequestParam(string $name): ?string
    {
        $params = $this->request->query->get('params', []);

        return isset($params[$name]) ? (string)$params[$name] : null;
    }

    /**
     * @inheritdoc
     */
    public function getPageSize($default = null): int
    {
        if(null === $default) {
            $default = self::$defaults['page_size'];
        }

        return (int)$this->request->query->get('length', (int)$default);
    }

    /**
     * @inheritdoc
     */
    public function getPage(): int
    {
        $offset = $this->request->query->get('start', 0);
        $size = $this->getPageSize();

        return (int)floor($offset / $size) + 1;
    }

    /**
     * @inheritdoc
     */
    public function getOffset(): int
    {
        return $this->request->query->get('start', 0);
    }

    /**
     * @inheritdoc
     */
    public function getSort($default = null): ?string
    {
        $order = $this->request->query->get('order', []);

        $columnIndex = isset($order[0]['column']) ? $order[0]['column'] : false;

        if (false === $columnIndex) {
            return $default ?: self::$defaults['sort'];
        }

        $columns = $this->request->query->get('columns', []);

        if (isset($columns[$columnIndex]['name'])) {
            $sort = $columns[$columnIndex]['name'];
        }else{
            return $default ?: self::$defaults['sort'];
        }

        return (string)($sort ?: $default);
    }

    /**
     * @inheritdoc
     */
    public function getOrder($default = null): ?string
    {
        $order = $this->request->query->get('order', []);

        if(isset($order[0]['dir'])) {
            return $order[0]['dir'];
        }

        return $default ?: self::$defaults['order'];
    }

    /**
     * @inheritdoc
     */
    public function getSearch(): ?string
    {
        $search = $this->request->query->get('search', []);
        return isset($search['value']) ? (string)$search['value'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getDraw(): int
    {
        return (int)$this->request->query->get('draw', 0);
    }
}
