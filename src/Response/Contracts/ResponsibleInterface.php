<?php
declare(strict_types=1);

namespace Beauty\Http\Response\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ResponsibleInterface
{
    /**
     * @return ResponseInterface
     */
    public function toResponse(): ResponseInterface;
}