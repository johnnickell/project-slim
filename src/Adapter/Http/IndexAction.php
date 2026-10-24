<?php

declare(strict_types=1);

namespace App\Adapter\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Presents the public starter readiness response
 */
final class IndexAction
{
    /**
     * Handles the root interaction
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write('Fight Slim starter is ready.');

        return $response;
    }
}
