<?php

declare(strict_types=1);

namespace riax20\Game21;

use riax20\Game21\DiceHand;
use riax20\Game21\GraphicalDice;

class Game21
{
    private int $nrOfDice;
    private array $latestDiceImages;
    private string $hideOnGameOver;
    private string $showOnGameOver;
    private array $sum;

    public function __construct(int $nrOfDice = 1)
    {
        $this->nrOfDice = $nrOfDice;
        $this->sum = [ "user" => 0, "cpu" => 0 ];
        $this->hideOnGameOver = "";
        $this->showOnGameOver = "hidden";
        $this->latestDiceImages = [];
    }

    public function playGame(): array
    {
        $data = [
            "message" => "Roll your dice again, or stop - your choice!"
        ];

        if (isset($_POST["clearstandings"])) {
            $_SESSION["cpuWins"] = 0;
            $_SESSION["userWins"] = 0;
        }

        if (isset($_POST["stop"])) {
            $sumCpu = $this->calculateCpuResult();
            $data["message"] = $this->gameOver($this->sum["user"], $sumCpu);
            $data["standings"] = $this->standings();
            $data["diceImages"] = $this->latestDiceImages;
            $data["hideOnGameOver"] = $this->hideOnGameOver;
            $data["showOnGameOver"] = $this->showOnGameOver;
            $data["userSum"] = $this->sum["user"];
            return $data;
        }

        $this->latestDiceImages = $this->newRoll("user");
        if ($this->sum["user"] >= 21) {
            $sumCpu = $this->calculateCpuResult();
            $data["message"] = $this->gameOver($this->sum["user"], $sumCpu);
            $data["standings"] = $this->standings();
        }
        $data["diceImages"] = $this->latestDiceImages;
        $data["hideOnGameOver"] = $this->hideOnGameOver;
        $data["showOnGameOver"] = $this->showOnGameOver;
        $data["userSum"] = $this->sum["user"];
        return $data;
    }

    private function gameOver(int $sumUser, int $sumCpu): string
    {
        $this->hideOnGameOver = "hidden";
        $this->showOnGameOver = "";
        $_SESSION["cpuWins"] = $_SESSION["cpuWins"] ?? 0;
        $_SESSION["userWins"] = $_SESSION["userWins"] ?? 0;
        $result = "";

        if ($sumUser <= 21) {
            if ($sumUser == 21) {
                $result = "<strong>WOW! You got 21!</strong> ";
            }

            if (($sumCpu > 21) || ($sumCpu < $sumUser)) {
                $_SESSION["userWins"] += 1;
                $result .= "You won!";
                $result .= " You got " . $sumUser . " points ";
                $result .= "and your opponent got " . $sumCpu . " points.";
                return $result;
            }

            $_SESSION["cpuWins"] += 1;
            $result .= "You lost!";
            $result .= " You got " . $sumUser . " points ";
            $result .= "and your opponent got " . $sumCpu . " points.";
            return $result;
        }

        $_SESSION["cpuWins"] += 1;
        $result = "You lost! You got " . $sumUser . " points.";
        return $result;
    }

    private function standings(): string
    {
        $standings = "Overall standings, Player vs. Opponent: ";
        $standings .= $_SESSION["userWins"] . " – " . $_SESSION["cpuWins"];
        return $standings;
    }

    private function calculateCpuResult(int $zero = 0)
    {
        $this->sum["cpu"] = $zero;
        while ($this->sum["cpu"] < 21) {
            $this->newRoll("cpu");
            if ($this->sum["cpu"] > $this->sum["user"]) {
                break;
            }
        }
        return $this->sum["cpu"];
    }

    private function newRoll(string $player, int $sides = 6): array
    {
        $roll = new DiceHand($this->nrOfDice, $sides);
        $rollValuesArray = $roll->getLastRolls();
        $nrOfRolls = count($rollValuesArray);
        for ($i=0; $i < $nrOfRolls; $i++) {
            $this->sum[$player] += intval($rollValuesArray[$i]);
        }
        return $roll->getLastRollsImages();
    }
}
