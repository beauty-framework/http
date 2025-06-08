<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

use Nyholm\Psr7\Response;

/**
 * Base JsonResponse
 *
 * @package Beauty/Http
 */
class JsonResponse extends Response
{
    /**
     * @param int $status
     * @param array|\JsonSerializable $data
     * @param array $headers
     * @param int $flags
     * @param string $version
     * @param string|null $reason
     */
    public function __construct(
        int                     $status = 200,
        array|\JsonSerializable $data = [],
        array                   $headers = [],
        int                     $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR,
        string                  $version = '1.1',
        string|null             $reason = null,
    ) {
        $json = json_encode($data, $flags);

        $headers = array_merge([
            'Content-Type' => 'application/json',
        ], $headers);

        parent::__construct($status, $headers, $json, $version, $reason);
    }
}