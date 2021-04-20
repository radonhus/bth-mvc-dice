<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller YatzyController.
 */
class ControllerYatzyTest extends TestCase
{
    /**
     * Test that object is instance of YatzyController
     */
    public function testCreateTheControllerClass()
    {
        $controller = new YatzyController();

        $this->assertInstanceOf("\Mos\Controller\YatzyController", $controller);
    }

    /**
     * Check that YatzyController class extends ControllerBase
     */
    public function testYatzyExtendsControllerBase()
    {
        $controller = new YatzyController();

        $this->assertInstanceOf("Mos\Controller\ControllerBase", $controller);
    }

    /**
     * Test that start returns a Response class object
     */
    public function testWelcomeReturnsResponseObject()
    {
        $controller = new YatzyController();

        $result = $controller->start();

        $this->assertInstanceOf("Nyholm\Psr7\Response", $result);
    }

    /**
     * Test that start saves a new Yatzy object in the Session variable
     */
    public function testStartYatzySession()
    {
        $controller = new YatzyController();

        $controller->start();

        $this->assertInstanceOf("riax20\Yatzy\Yatzy", $_SESSION["yatzy"]);
    }

    /**
     * Test that play returns a Response class object
     */
    public function testPlayReturnsResponseObject()
    {
        $controller = new YatzyController();

        $result = $controller->play();

        $this->assertInstanceOf("Nyholm\Psr7\Response", $result);
    }

}
