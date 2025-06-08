<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;

class BinaryFileResponse extends Response
{
    /**
     * @param string $filepath
     * @param string|null $filename
     * @param string $contentType
     */
    public function __construct(string $filepath, string|null $filename = null, string $contentType = 'application/octet-stream')
    {
        if (!is_readable($filepath)) {
            throw new \RuntimeException("File not readable: $filepath");
        }

        $filename ??= basename($filepath);

        $stream = Stream::create(fopen($filepath, 'r'));

        parent::__construct(200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => filesize($filepath),
        ], $stream);
    }
}