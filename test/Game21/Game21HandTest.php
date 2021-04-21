<?php

declare(strict_types=1);

namespace riax20\Game21;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the DiceHand class of the Game21 game.
 */
class Game21HandTest extends TestCase
{

    /**
     * Test that object is instance of DiceHand
     */
    public function testInstanceOfDiceHand()
    {
        $testHand = new DiceHand(1);

        $this->assertInstanceOf("riax20\Game21\DiceHand", $testHand);
    }

    /**
     * Test that object has the allDice attribute
     */
    public function testHasDiceArray()
    {
        $testHand = new DiceHand(1);

        $this->assertObjectHasAttribute("allDice", $testHand);
    }

    /**
     * Test that rollAllDice returns array with correct nr of keys = dice
     */
    public function testRollAllDiceArrayLength()
    {
        $testHand = new DiceHand(5);

        $arrayOfDice = $testHand->rollAllDice();

        $this->assertArrayHasKey(4, $arrayOfDice);
    }

    /**
     * Test that rollAllDice returns array with GraphicalDice objects
     */
    public function testRollAllDiceGraphicalDice()
    {
        $testHand = new DiceHand(1);

        $arrayOfDice = $testHand->rollAllDice();

        $this->assertInstanceOf("riax20\Game21\GraphicalDice", $arrayOfDice[0]);
    }


    /**
     * Test that getLastRolls returns array of integers
     */
    public function testGetLastRollsIntegers()
    {
        $testHand = new DiceHand(3);

        $arrayDiceValues = $testHand->getLastRolls();

        $this->assertIsInt($arrayDiceValues[0]);
        $this->assertIsInt($arrayDiceValues[1]);
        $this->assertIsInt($arrayDiceValues[2]);
    }

    /**
     * Test that getLastRollsImages items contain the string "dice-"
     */
    public function testGetLastRollsImagesString()
    {
        $testHand = new DiceHand(3);

        $arrayDiceImages = $testHand->getLastRollsImages();

        $this->assertStringContainsString("dice-", $arrayDiceImages[0]);
        $this->assertStringContainsString("dice-", $arrayDiceImages[1]);
        $this->assertStringContainsString("dice-", $arrayDiceImages[2]);
    }
}
