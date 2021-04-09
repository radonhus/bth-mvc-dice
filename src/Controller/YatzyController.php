<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

use riax20\Yatzy\Round;

/**
 * Controller for a sample route an controller class.
 */
class YatzyController
{
    public function welcome(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "message" => "Let's play!",
        ];

        $data["hand"] = new Round();
        $data["test"] = $data["hand"]->getValues();
        $data["hand"]->rollDice([4, 3]);
        $data["test2"] = $data["hand"]->getValues();

        $body = renderView("layout/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

}
