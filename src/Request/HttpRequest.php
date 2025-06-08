<?php
declare(strict_types=1);

namespace Beauty\Http\Request;

use Nyholm\Psr7\ServerRequest;

/**
 * Base HTTP request
 *
 * @package Beauty/Http
 */
class HttpRequest extends ServerRequest
{
    /**
     * @var array|null
     */
    protected array|null $jsonBody = null;

    /**
     * Get request input from all sources
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input(string $key, mixed $default = null): mixed
    {
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    /**
     * Get all request data
     *
     * @return array
     */
    public function all(): array
    {
        return array_merge(
            $this->getQueryParams(),
            $this->getParsedBody() ?? [],
            $this->json() ?? []
        );
    }

    /**
     * Has request data by key
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->all());
    }

    /**
     * Get request query by key
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->getQueryParams()[$key] ?? $default;
    }

    /**
     * Get request body by key
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function body(string $key, mixed $default = null): mixed
    {
        return $this->getParsedBody()[$key] ?? $default;
    }

    /**
     * Get request json
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function json(string|null $key = null, mixed $default = null): mixed
    {
        if ($this->jsonBody === null) {
            $body = (string) $this->getBody();
            $this->jsonBody = json_decode($body, true) ?? [];
        }

        if ($key === null) {
            return $this->jsonBody;
        }

        return $this->jsonBody[$key] ?? $default;
    }
}