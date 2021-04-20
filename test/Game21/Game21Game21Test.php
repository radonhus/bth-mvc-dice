<?php

declare(strict_types=1);

namespace riax20\Game21;

use ReflectionMethod;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the Game21 class of the Game21 game.
 */
class Game21Game21Test extends TestCase
{

    /**
     * Test that object is instance of Game21
     */
    public function testInstanceOfGame21()
    {
        $testGame = new Game21(1);

        $this->assertInstanceOf("riax20\Game21\Game21", $testGame);
    }

    /**
     * Test that playGame sets hideOnGameOver-key to "hidden" if
     * $_POST["stop"] is set.
     */
    public function testPlayGameStop()
    {
        $testGame = new Game21(1);
        $_POST = ["stop" => "stop"];

        $data = $testGame->playGame();

        $this->assertEquals("hidden", $data["hideOnGameOver"]);
    }

    /**
     * Test that playGame clears standings if
     * $_POST["clearstandings"] is set.
     */
    public function testPlayGameClearStandings()
    {
        $testGame = new Game21(1);
        $_SESSION = [
            "cpuWins" => 5,
            "userWins" => 5
        ];
        $_POST = ["clearstandings" => "clearstandings"];

        $data = $testGame->playGame();

        $this->assertEquals(0, $_SESSION["cpuWins"]);
        $this->assertEquals(0, $_SESSION["userWins"]);
    }

    /**
     * Test that dice values accumulate with each round
     */
    public function testPlayGameIncreasesSum()
    {
        $testGame = new Game21(1);

        $dataInitial = $testGame->playGame();
        $dataSecond = $testGame->playGame();
        $dataThird = $testGame->playGame();

        $this->assertGreaterThan($dataInitial["userSum"], $dataSecond["userSum"]);
        $this->assertGreaterThan($dataSecond["userSum"], $dataThird["userSum"]);
    }

    /**
     * Test that an accumulated score higher than 21 can be reached (if 22 dice
     * are rolled, a score of at least 22 is guaranteed), and triggers
     * gameOver to be called.
     */
    public function testPlayGameOver21()
    {
        $testGame = new Game21(22);

        $data = $testGame->playGame();

        $this->assertGreaterThan(21, $data["userSum"]);
        $this->assertStringStartsWith("You ", $data["message"]);
    }

    /**
     * Test that gameOver returns string type value starting with "You "
     */
    public function testGameOverReturnsString()
    {
        $publicGameOver = new ReflectionMethod("riax20\Game21\Game21", "gameOver");
        $publicGameOver->setAccessible(true);

        $testGame = new Game21(1);
        $result = $publicGameOver->invokeArgs($testGame, [5, 8]);

        $this->assertIsString($result);
        $this->assertStringStartsWith("You ", $result);
    }

    /**
     * Test that standings returns string type value starting with "Overall "
     */
    public function testStandingsReturnsString()
    {
        $publicStandings = new ReflectionMethod("riax20\Game21\Game21", "standings");
        $publicStandings->setAccessible(true);

        $testGame = new Game21(1);
        $result = $publicStandings->invoke($testGame);

        $this->assertIsString($result);
        $this->assertStringStartsWith("Overall ", $result);
    }

    /**
     * Test that calculateCpuResult returns integer value between 1 and 6
     */
    public function testcalculateCpuResultReturnsInteger()
    {
        $publicCalculateCpuResult = new ReflectionMethod(
            "riax20\Game21\Game21",
            "calculateCpuResult"
        );
        $publicCalculateCpuResult->setAccessible(true);

        $testGame = new Game21(1);
        $result = $publicCalculateCpuResult->invoke($testGame);

        $this->assertIsInt($result);
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertLessThanOrEqual(6, $result);
    }

    /**
     * Test that newRoll returns array of string values starting with "dice-"
     */
    public function testNewRollReturnsStrings()
    {
        $publicNewRoll = new ReflectionMethod("riax20\Game21\Game21", "newRoll");
        $publicNewRoll->setAccessible(true);

        $testGame = new Game21(2);
        $arrayDiceImages = $publicNewRoll->invoke($testGame, "user");

        $this->assertStringContainsString("dice-", $arrayDiceImages[0]);
        $this->assertStringContainsString("dice-", $arrayDiceImages[1]);
    }

    /**
     * Test that user wins if user score is 21 and cpu score is > 21
     */
    public function testGameOverCpuOver21UserWins()
    {
        $publicNewRoll = new ReflectionMethod("riax20\Game21\Game21", "newRoll");
        $publicNewRoll->setAccessible(true);
        $publicGameOver = new ReflectionMethod("riax20\Game21\Game21", "gameOver");
        $publicGameOver->setAccessible(true);

        $testGame = new Game21(1);

        $result = $publicGameOver->invokeArgs($testGame, [21, 22]);

        $this->assertStringContainsString("You won!", $result);
    }
}
