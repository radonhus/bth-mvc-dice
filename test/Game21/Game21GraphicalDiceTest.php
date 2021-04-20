<?php

declare(strict_types=1);

namespace riax20\Game21;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the GraphicalDice class of the Game21 game.
 */
class Game21GraphicalDiceTest extends TestCase
{

    /**
     * Test that object is instance of GraphicalDice and Dice
     */
    public function testInstanceOfGraphicalDice()
    {
        $testDice = new GraphicalDice();

        $this->assertInstanceOf("riax20\Game21\GraphicalDice", $testDice);
        $this->assertInstanceOf("riax20\Game21\Dice", $testDice);
    }

    /**
     * Test that diceImage returns string containing "dice-"
     */
    public function testDiceImageContainsString()
    {
        $testDice = new GraphicalDice();

        $testString = $testDice->diceImage();

        $this->assertStringContainsString("dice-", $testString);
    }

}
