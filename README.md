# Beauty HTTP Component

The `beauty-framework/http` package is a lightweight, PSR-compatible HTTP layer for building clean, modular, and fast REST APIs. It is designed to be used as part of the `beauty-framework/app`, but can also be used independently in any modern PHP project.

---

## Features

* PSR-7 compatible `HttpRequest` and custom `JsonResponse`
* PSR-15 compatible middleware system via `AbstractMiddleware`
* Route-level middleware via PHP 8 attributes
* Support for:

    * `JsonResponse`
    * `StreamedResponse`
    * `BinaryFileResponse`
    * `RedirectResponse`
* `ResponsibleInterface` for clean resource-to-response conversion
* Resource system similar to Laravel's `JsonResource`
* Type-safe request abstraction for validated input (`HttpRequest` extensions)
* Extendable response normalization via `ResponseFactory`

---

## Installation

```bash
composer require beauty-framework/http
```

---

## Usage Example

### Validated Request
```php
namespace App\Requests;

use Beauty\Http\Request\AbstractValidatedRequest;

class CreateUserRequest extends AbstractValidatedRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ];
    }
}
```

```php
use Beauty\Http\Enums\HttpMethodsEnum;
use App\Requests\CreateUserRequest;

class UserController
{
    #[Route(HttpMethodsEnum::POST, '/create')]
    public function create(CreateUserRequest $request): ResponsibleInterface
    {
        // ...
    }
}
```

### JsonResponse

```php
use Beauty\Http\Response\JsonResponse;

return new JsonResponse(200, ['message' => 'Hello world']);
```

### Redirect

```php
use Beauty\Http\Response\RedirectResponse;

return new RedirectResponse('/login');
```

### File Download

```php
use Beauty\Http\Response\BinaryFileResponse;

return new BinaryFileResponse('/path/to/report.pdf');
```

### Streamed Response

```php
use Beauty\Http\Response\StreamedResponse;

return new StreamedResponse(function () {
    echo json_encode(['streamed' => true]);
});
```

### Custom Resource

```php
use Beauty\Http\Response\AbstractJsonResource;

class UserResource extends AbstractJsonResource
{
    protected array $fields = ['id', 'name', 'email'];

    public function __construct(private object $user)
    {
        foreach ($this->fields as $field) {
            $this->{$field} = $user->{$field};
        }
    }
}

return (new UserResource($user))->setStatusCode(201);
```

---

## Middleware (PSR-15 via AbstractMiddleware)

```php
use Beauty\Http\Middleware\AbstractMiddleware;
use Beauty\Http\HttpRequest;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

class ExampleMiddleware extends AbstractMiddleware
{
    public function handle(HttpRequest $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->query('blocked')) {
            return new JsonResponse(403, ['error' => 'Access denied']);
        }

        return $handler->handle($request);
    }
}
```

---

## Attribute-Based Middleware

```php
use Beauty\Http\Attributes\Middleware;
use Beauty\Http\Response\Contracts\ResponsibleInterface;

#[Middleware(AuthMiddleware::class)]
class UserController
{
    #[Route(HttpMethodsEnum::GET, '/me')]
    #[Middleware(ThrottleMiddleware::class)]
    public function me(): ResponsibleInterface
    {
        // ...
    }
}
```

---

## Testing

```bash
./vendor/bin/phpunit
```

Tests are included for all response types and middleware pipeline behavior.

---

## License

MIT License.
