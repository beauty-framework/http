<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;

class StreamResponse extends Response
{
    /**
     * @param callable $streamGenerator
     * @param int $status
     * @param array $headers
     */
    public function __construct(callable $streamGenerator, int $status = 200, array $headers = [])
    {
        $resource = fopen('php://temp', 'r+');

        ob_start();
        $streamGenerator();
        $content = ob_get_clean();

        fwrite($resource, $content);
        rewind($resource);

        parent::__construct($status, $headers, Stream::create($resource));
    }
}