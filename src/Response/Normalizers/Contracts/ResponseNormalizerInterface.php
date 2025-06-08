<?php
declare(strict_types=1);

namespace Beauty\Http\Response\Normalizers\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ResponseNormalizerInterface
{
    /**
     * @param mixed $data
     * @return ResponseInterface
     */
    public function normalize(mixed $data): ResponseInterface;
}