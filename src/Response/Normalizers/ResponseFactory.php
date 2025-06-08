<?php
declare(strict_types=1);

namespace Beauty\Http\Response\Normalizers;

use Psr\Http\Message\ResponseInterface;
use Beauty\Http\Response\Normalizers\Contracts\ResponseNormalizerInterface;

class ResponseFactory
{
    /**
     * @var array
     */
    protected array $normalizers = [];

    /**
     *
     */
    public function __construct()
    {
        $this->addNormalizer(new DefaultResponseNormalizer());
    }

    /**
     * @param ResponseNormalizerInterface $normalizer
     * @return void
     */
    public function addNormalizer(ResponseNormalizerInterface $normalizer): void
    {
        array_unshift($this->normalizers, $normalizer);
    }

    /**
     * @param mixed $result
     * @return ResponseInterface
     */
    public function make(mixed $result): ResponseInterface
    {
        foreach ($this->normalizers as $normalizer) {
            try {
                return $normalizer->normalize($result);
            } catch (\Throwable) {
                continue;
            }
        }

        throw new \RuntimeException('No response normalizer could handle the result.');
    }
}