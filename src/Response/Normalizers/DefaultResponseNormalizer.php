<?php
declare(strict_types=1);

namespace Beauty\Http\Response\Normalizers;

use Beauty\Http\Response\JsonResponse;
use Beauty\Http\Response\Contracts\ResponsibleInterface;
use Beauty\Http\Response\Normalizers\Contracts\ResponseNormalizerInterface;
use JsonSerializable;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class DefaultResponseNormalizer implements ResponseNormalizerInterface
{

    /**
     * @param mixed $data
     * @return ResponseInterface
     */
    public function normalize(mixed $data): ResponseInterface
    {
        if ($data instanceof ResponseInterface) {
            return $data;
        }

        if ($data instanceof ResponsibleInterface) {
            return $data->toResponse();
        }

        if ($data instanceof JsonSerializable || is_array($data) || is_object($data)) {
            return new JsonResponse(200, $data);
        }

        if (is_string($data)) {
            return new Response(200, ['Content-Type' => 'text/plain'], $data);
        }

        if ($data === null) {
            return new Response(204);
        }

        throw new \RuntimeException('Unable to normalize controller response');
    }
}