<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Base class for controller classes, for inheritance
 */
class ControllerBase
{
    protected function response(string $body, int $status = 200): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        return $psr17Factory
            ->createResponse($status)
            ->withBody($psr17Factory->createStream($body));
    }
}
