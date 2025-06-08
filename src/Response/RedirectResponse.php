<?php
declare(strict_types=1);

namespace Beauty\Http\Response;

use Nyholm\Psr7\Response;

class RedirectResponse extends Response
{
    /**
     * @param string $location
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $location, int $status = 302, array $headers = [])
    {
        $headers['Location'] = $location;
        parent::__construct($status, $headers);
    }
}