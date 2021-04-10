<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

use riax20\Yatzy\Yatzy;

/**
 * Controller class for Yatzy
 */
class YatzyController extends ControllerBase
{
    public function start(): ResponseInterface
    {
        $_SESSION["yatzy"] = new Yatzy();
        $data = $_SESSION["yatzy"]->startNewRound();

        $body = renderView("layout/yatzy.php", $data);

        return $this->response($body);
    }

    public function play(): ResponseInterface
    {

        $data = $_SESSION["yatzy"]->play($_POST);

        $body = renderView("layout/yatzy.php", $data);

        return $this->response($body);
    }

}
