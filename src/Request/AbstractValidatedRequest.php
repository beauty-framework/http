<?php
declare(strict_types=1);

namespace Beauty\Http\Request;

use Beauty\Http\Request\Exceptions\ValidationException;
use Beauty\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Base class for validated request
 *
 * Class AbstractValidatedRequest
 * @package Beauty\Http\Request
 */
abstract class AbstractValidatedRequest extends HttpRequest
{
    /**
     * @var array
     */
    protected array $validatedData = [];

    /**
     * @param ServerRequestInterface $base
     * @throws ValidationException
     */
    public function __construct(ServerRequestInterface $base)
    {
        parent::__construct(
            $base->getMethod(),
            (string) $base->getUri(),
            $base->getHeaders(),
            $base->getBody(),
            $base->getProtocolVersion(),
            $base->getServerParams()
        );

        $this->withQueryParams($base->getQueryParams());
        $this->withParsedBody($base->getParsedBody());
        $this->withUploadedFiles($base->getUploadedFiles());
        $this->withCookieParams($base->getCookieParams());

        foreach ($base->getAttributes() as $key => $value) {
            $this->withAttribute($key, $value);
        }

        $this->validateResolved();
    }

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        return $this->validatedData;
    }

    /**
     * @return bool
     */
    public function fails(): bool
    {
        return empty($this->validatedData);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    protected function validateResolved(): void
    {
        if (!$this->authorize()) {
            throw new \RuntimeException('Unauthorized.');
        }

        $validator = new Validator();

        $validation = $validator->make($this->all(), $this->rules());
        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException('Validation failed', $validation->errors()->toArray());
        }

        $this->validatedData = $validation->getValidData();
    }
}