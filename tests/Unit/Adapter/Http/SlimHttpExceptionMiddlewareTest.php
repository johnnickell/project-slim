<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Http;

use App\Adapter\Http\SlimHttpExceptionMiddleware;
use Fight\Common\Adapter\Http\Psr17\JSendResponseFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;

final class SlimHttpExceptionMiddlewareTest extends TestCase
{
    public function test_successful_downstream_response_is_preserved(): void
    {
        $response = (new ResponseFactory())->createResponse(202)->withHeader('X-Result', 'accepted');
        $handler = new class ($response) implements RequestHandlerInterface {
            public function __construct(private readonly ResponseInterface $response)
            {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        self::assertSame($response, $this->middleware()->process($this->request(), $handler));
    }

    #[DataProvider('httpStatuses')]
    public function test_http_exception_status_is_bounded(int $code, int $expectedStatus): void
    {
        $handler = $this->throwingHandler(new HttpException($this->request(), 'Boundary failure', $code));

        $response = $this->middleware()->process($this->request(), $handler);

        self::assertSame($expectedStatus, $response->getStatusCode());
        self::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        self::assertSame('error', json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR)['status']);
    }

    public static function httpStatuses(): iterable
    {
        yield 'below HTTP error range' => [399, 500];
        yield 'first HTTP error' => [400, 400];
        yield 'last HTTP error' => [599, 599];
        yield 'above HTTP error range' => [600, 500];
    }

    public function test_unrelated_failure_is_left_to_the_outer_error_boundary(): void
    {
        $failure = new \RuntimeException('Outer boundary owns this failure');

        $this->expectExceptionObject($failure);

        $this->middleware()->process($this->request(), $this->throwingHandler($failure));
    }

    private function middleware(): SlimHttpExceptionMiddleware
    {
        return new SlimHttpExceptionMiddleware(new JSendResponseFactory(new ResponseFactory(), new StreamFactory()));
    }

    private function request(): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest('GET', '/');
    }

    private function throwingHandler(\Throwable $failure): RequestHandlerInterface
    {
        return new class ($failure) implements RequestHandlerInterface {
            public function __construct(private readonly \Throwable $failure)
            {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw $this->failure;
            }
        };
    }
}
