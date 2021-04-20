<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

use riax20\Game21\Game21;

/**
 * Controller class for Game21
 */
class Game21Controller extends ControllerBase
{
    public function welcome(): ResponseInterface
    {
        $data = [
            "message" => "Let's play!",
        ];

        $body = renderView("layout/dicestart.php", $data);
        return $this->response($body);
    }

    public function initiate(): ResponseInterface
    {

        $_SESSION["play"] = new Game21(intval($_POST["oneortwo"]));

        $data = $_SESSION["play"]->playGame();
        $body = renderView("layout/diceplay.php", $data);

        return $this->response($body);
    }

    public function play(): ResponseInterface
    {

        $data = $_SESSION["play"]->playGame();
        $body = renderView("layout/diceplay.php", $data);

        return $this->response($body);
    }

}
