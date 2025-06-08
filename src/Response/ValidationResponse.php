<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

final class ValidationResponse extends AbstractJsonResource
{
    /**
     * @var string[]
     */
    protected array $fields = ['message', 'fails'];

    /**
     * @param string $message
     * @param array|object $fails
     */
    public function __construct(
        protected string $message,
        protected array|object $fails,
    )
    {
    }
}