<?php
declare(strict_types=1);

namespace Beauty\Http\Middleware;

use Beauty\Http\Middleware\Contracts\MiddlewareInterface;
use Beauty\Http\Request\HttpRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->handle($request, $handler);
    }

    abstract public function handle(HttpRequest $request, RequestHandlerInterface $next): ResponseInterface;
}