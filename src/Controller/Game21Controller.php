<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

use riax20\Dice\Game21;

/**
 * Controller for a sample route an controller class.
 */
class Game21Controller
{
    public function welcome(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "message" => "Let's play!",
        ];

        $body = renderView("layout/dicestart.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function initiate(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["play"] = new Game21(intval($_POST["oneortwo"]));

        $data = $_SESSION["play"]->playGame();
        $body = renderView("layout/diceplay.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = $_SESSION["play"]->playGame();
        $body = renderView("layout/diceplay.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

}
