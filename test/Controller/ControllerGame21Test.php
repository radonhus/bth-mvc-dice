<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Game21Controller.
 */
class ControllerGame21Test extends TestCase
{
    /**
     * Test that object is instance of Game21Controller
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Game21Controller();

        $this->assertInstanceOf("\Mos\Controller\Game21Controller", $controller);
    }

    /**
     * Check that Game21Controller class extends ControllerBase
     */
    public function testGame21ExtendsControllerBase()
    {
        $controller = new Game21Controller();

        $this->assertInstanceOf("Mos\Controller\ControllerBase", $controller);
    }

    /**
     * Test that welcome returns a Response class object
     */
    public function testWelcomeReturnsResponseObject()
    {
        $controller = new Game21Controller();

        $result = $controller->welcome();

        $this->assertInstanceOf("Nyholm\Psr7\Response", $result);
    }

    /**
     * Test that initiate saves a new Game21 object in the Session variable
     */
    public function testInitateGame21Session()
    {
        $controller = new Game21Controller();

        $_POST = ["oneortwo" => 1];

        $controller->initiate();

        $this->assertInstanceOf("riax20\Game21\Game21", $_SESSION["play"]);
    }

    /**
     * Test that play returns a Response class object
     */
    public function testPlayReturnsResponseObject()
    {
        $controller = new Game21Controller();

        $result = $controller->play();

        $this->assertInstanceOf("Nyholm\Psr7\Response", $result);
    }
}
