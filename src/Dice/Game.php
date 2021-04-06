<?php

declare(strict_types=1);

namespace riax20\Dice;

use function Mos\Functions\{
    renderView,
    sendResponse
};

use riax20\Dice\DiceHand;
use riax20\Dice\GraphicalDice;

// Spara själva Game-instansen i en session-variabel istället för de olika
// variablerna!!

class Game
{
    private int $nrOfDice;
    private array $latestDiceImages;
    private string $hideOnGameOver;
    private string $showOnGameOver;
    private array $sum;

    public function __construct($nrOfDice)
    {
        $this->nrOfDice = $nrOfDice;
        $this->sum = [ "user" => 0, "cpu" => 0 ];
        $this->hideOnGameOver = "";
        $this->showOnGameOver = "hidden";
        $this->latestDiceImages = [];
    }

    public function playGame(): void
    {
        $data = [
            "message" => "Your choice: roll your dice or stop!"
        ];

        if (isset($_POST["stop"])) {
            $data["message"] = $this->gameOver();
            $data["standings"] = $this->standings();
            $this->callRenderView($data);
            return;
        }

        $this->latestDiceImages = $this->newRoll("user");
        if ($this->sum["user"] >= 21) {
             $data["message"] = $this->gameOver();
             $data["standings"] = $this->standings();
        }
        $this->callRenderView($data);
        return;

    }

    private function callRenderView($data): void
    {
        $data["diceImages"] = $this->latestDiceImages;
        $data["hideOnGameOver"] = $this->hideOnGameOver;
        $data["showOnGameOver"] = $this->showOnGameOver;
        $data["userSum"] = $this->sum["user"];

        $body = renderView("layout/diceplay.php", $data);
        sendResponse($body);
    }

    private function gameOver(): string
    {
        $this->hideOnGameOver = "hidden";
        $this->showOnGameOver = "";
        $_SESSION["cpuWins"] = $_SESSION["cpuWins"] ?? 0;
        $_SESSION["userWins"] = $_SESSION["userWins"] ?? 0;
        $result = "";

        if ($this->sum["user"] <= 21) {
            $this->opponentResult(0);
            if ($this->sum["user"] == 21) {
                $result = "<strong>WOW! You got 21!</strong> ";
            }

            if (($this->sum["cpu"] > 21) || ($this->sum["cpu"] < $this->sum["user"])) {
                $_SESSION["userWins"] += 1;
                $result .= "You won!";
                $result .= " You got " . $this->sum["user"] . " points ";
                $result .= "and your opponent got " . $this->sum["cpu"] . " points.";
                return $result;
            }

            $_SESSION["cpuWins"] += 1;
            $result .= "You lost!";
            $result .= " You got " . $this->sum["user"] . " points ";
            $result .= "and your opponent got " . $this->sum["cpu"] . " points.";
            return $result;
        }

        $_SESSION["cpuWins"] += 1;
        $result = "You lost! You got " . $this->sum["user"] . " points.";
        return $result;
    }

    private function standings(): string
    {
        $standings = "Overall standings, Player vs. Opponent: ";
        $standings .= $_SESSION["userWins"] . " – " . $_SESSION["cpuWins"];
        return $standings;
    }

    private function opponentResult($zero)
    {
        $this->sum["cpu"] = $zero;
        while ($this->sum["cpu"] < 21) {
            $this->newRoll("cpu");
            if ($this->sum["cpu"] > $this->sum["user"]) {
                break;
            }
        }
    }

    private function newRoll($player): array
    {
        $roll = new DiceHand($this->nrOfDice);
        $rollValuesArray = $roll->getLastRolls();
        $nrOfRolls = count($rollValuesArray);
        for ($i=0; $i < $nrOfRolls ; $i++) {
            $this->sum[$player] += intval($rollValuesArray[$i]);
        }
            return $roll->getLastRollsImages();
    }
}
