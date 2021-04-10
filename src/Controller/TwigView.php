<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderTwigView;

/**
 * Controller for showing how Twig views works.
 */
class TwigView extends ControllerBase
{
    public function __invoke(): ResponseInterface
    {
        $data = [
            "header" => "Twig page",
            "message" => "Hey, edit this to do it youreself!",
        ];

        $body = renderTwigView("index.html", $data);

        return $this->response($body);
    }
}
