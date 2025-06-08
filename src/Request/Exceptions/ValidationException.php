<?php
declare(strict_types=1);

namespace Beauty\Http\Request\Exceptions;

class ValidationException extends \Exception
{
    /**
     * @var array|object
     */
    protected array|object $fails;

    /**
     * @param string $message
     * @param array|object $fails
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", array|object $fails = [], int $code = 0, ?Throwable $previous = null)
    {
        $this->fails = $fails;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return object|array
     */
    public function getFails(): object|array
    {
        return $this->fails;
    }
}