<?php

declare(strict_types=1);

namespace riax20\Yatzy;

use riax20\Yatzy\Round;

class Yatzy
{
    public int $roundsCounter;
    private int $totalPoints;
    private object $currentRound;

    public function __construct()
    {
        $this->roundsCounter = 0;
        $this->totalPoints = 0;
    }

    public function startNewRound(): array
    {
        $rollsAndValues = [];
        $data = [];

        $this->roundsCounter += 1;
        $this->currentRound = new Round();
        $rollsAndValues = $this->currentRound->getRollsAndValues();

        $data["nrOfRerolls"] = $rollsAndValues[0];
        $data["diceArray"] = array_slice($rollsAndValues, -5);
        $data["round"] = $this->roundsCounter;
        $data["totalPoints"] = $this->totalPoints;
        $data["hideOnRoundOver"] = "";
        $data["showOnRoundOver"] = "hidden";
        $data["hideOnGameOver"] = "";
        $data["showOnGameOver"] = "hidden";

        return $data;
    }

    public function play($post): array
    {
        if (isset($post["nextround"])) {
            return $this->startNewRound();
        }
        $diceToReroll = [];
        for ($i=0; $i <5 ; $i++) {
            if (isset($post[strval($i)])) {
                array_push($diceToReroll, $i);
            }
        }
        return $this->reRoll($diceToReroll);
    }

    public function reRoll($diceToReroll): array
    {
        $rollsAndValues = [];
        $data = [];

        $rollsAndValues = $this->currentRound->rollDice($diceToReroll);

        $data["nrOfRerolls"] = $rollsAndValues[0];
        $data["diceArray"] = array_slice($rollsAndValues, -5);
        $data["round"] = $this->roundsCounter;
        $data["totalPoints"] = $this->totalPoints;
        $data["hideOnRoundOver"] = "";
        $data["showOnRoundOver"] = "hidden";
        $data["hideOnGameOver"] = "";
        $data["showOnGameOver"] = "hidden";

        if ($data["nrOfRerolls"] == 2) {
            $this->calculatePoints($data["diceArray"]);
            $data["totalPoints"] = $this->totalPoints;
            $data["hideOnRoundOver"] = "hidden";
            $data["showOnRoundOver"] = "";
            if ($this->roundsCounter == 6) {
                $data["hideOnGameOver"] = "hidden";
                $data["showOnGameOver"] = "";
            }
        }
        return $data;
    }

    private function calculatePoints($diceArray): void
    {
        foreach ($diceArray as $value) {
            if ($value == $this->roundsCounter) {
                $this->totalPoints += $value;
            }
        }
        if (($this->roundsCounter == 6) && ($this->totalPoints >= 63)) {
            $this->totalPoints += 50;
        }
    }
}
