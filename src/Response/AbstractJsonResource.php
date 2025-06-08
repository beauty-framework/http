<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Beauty\Http\Response\Contracts\ResponsibleInterface;

abstract class AbstractJsonResource implements \JsonSerializable, ResponsibleInterface
{
    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @var array<string, string>
     */
    private array $headers = [];

    /**
     * @var int
     */
    private int $status = 200;

    /**
     * @param iterable $items
     * @return array
     */
    public static function collection(iterable $items): array
    {
        return array_map(fn($item) => (new static($item))->jsonSerialize(), $items);
    }

    /**
     * @return ResponseInterface
     */
    public function toResponse(): ResponseInterface
    {
        return new JsonResponse($this->status, $this, $this->headers);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [];

        foreach ($this->fields as $key => $property) {
            if (is_int($key)) {
                $key = $property;
            }

            $result[$key] = $this->{$property};
        }

        return $result;
    }

    /**
     * @param int $status
     * @return AbstractJsonResource
     */
    public function setStatusCode(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setHeader(string $key, string $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): static
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }

        return $this;
    }
}