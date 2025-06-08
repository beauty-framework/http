<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

final class ErrorResponse extends AbstractJsonResource
{
    /**
     * @var array|string[]
     */
    protected array $fields = ['message', 'errors'];

    /**
     * @param string $message
     * @param array|object|null $errors
     */
    public function __construct(
        protected string $message,
        protected array|object|null $errors = null,
    )
    {
    }
}