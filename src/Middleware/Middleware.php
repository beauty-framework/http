<?php
declare(strict_types=1);

namespace Beauty\Http\Middleware;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Middleware
{
    /**
     * @param class-string[]|class-string $middlewares
     */
    public function __construct(
        public array|string $middlewares
    )
    {
    }
}