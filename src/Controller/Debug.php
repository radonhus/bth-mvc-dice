<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the debug route.
 */
class Debug extends ControllerBase
{
    public function __invoke(): ResponseInterface
    {

        $body = renderView("layout/debug.php");

        return $this->response($body);
    }
}
