<?php

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestManager
{
    /** @var Request|null $request */
    private ?Request $request;

    /** @var array|mixed|null  */
    private $requestContent;

    /**
     * RequestManager constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->requestContent = self::decodeRequestContent($this->request);
    }

    /**
     * Sert à check si la clé existe dans le bag de la Request en elle-même ou dans le requestContent
     * (notamment utile pour les requêtes ajax avec axios)
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->request->get($key, $default) ?? ($this->requestContent[$key] ?? $default);
    }

    /**
     * @return Request|null
     */
    public function getCurrentRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return array|mixed|null
     */
    public function getDecodedRequestContent()
    {
        return self::decodeRequestContent($this->request);
    }

    public static function decodeRequestContent(Request $request, bool $assoc = true)
    {
        return json_decode($request->getContent(), $assoc) ?? [];
    }

    /**
     * @return array
     */
    public function getPaginationVariables(): array
    {
        $requestQuery = $this->getCurrentRequest()->query;
        $page = $requestQuery->getInt('page', 1);
        $limit = $requestQuery->getInt('limit', 10);

        return [$page, $limit];
    }
}
