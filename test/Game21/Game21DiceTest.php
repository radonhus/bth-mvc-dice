<?php

declare(strict_types=1);

namespace riax20\Game21;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Dice class of the Game21 game.
 */
class Game21DiceTest extends TestCase
{

    /**
     * Test that object is instance of Dice
     */
    public function testInstanceOfDice()
    {
        $testDice = new Dice(6);
        $this->assertInstanceOf("riax20\Game21\Dice", $testDice);
    }

    /**
     * Test that 1-sided dice returns 1
     */
    public function testGetLastRollReturns1()
    {
        $testDice = new Dice(1);
        $this->assertEquals(1, $testDice->getLastRoll());
    }

    /**
     * Test that value is integer between > 0 and < 11
     */
    public function testGetLastRollWithinBounds()
    {
        $testDice = new Dice(10);

        $this->assertIsInt($testDice->getLastRoll());

        $this->assertGreaterThanOrEqual(1, $testDice->getLastRoll());
        $this->assertLessThanOrEqual(10, $testDice->getLastRoll());
    }

    /**
     * Test that changeDiceSize results in 1-sided dice
     */
    public function testChangeDiceSizeProducesCorrectSize()
    {
        $testDice = new Dice(6);
        $testDice->changeDiceSize(1);
        $testDice->rollDice();

        $this->assertEquals(1, $testDice->getLastRoll());
    }
}
