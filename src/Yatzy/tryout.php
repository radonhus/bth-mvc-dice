<?php

declare(strict_types=1);

class Dice
{
    private int $value;

    public function __construct()
    {
        $this->rollOneDice();
    }

    public function rollOneDice(): int
    {
        $this->value = rand(1, 6);

        return $this->value;
    }

    public function getDiceValue(): int
    {
        return $this->value;
    }
}

class Hand
{
    private array $diceArray;

    public function __construct()
    {
        $this->diceArray = [];
        for ($i = 0; $i < 5 ; $i++) {
            $oneNewDice = new Dice();
            array_push($this->diceArray, $oneNewDice);
        }
    }

    public function rollSelectedDice($keys): array
    {
        $newDiceValues = [];
        $nrOfDice = count($keys);
        for ($i=0; $i < $nrOfDice ; $i++) {
            $diceNr = $keys[$i];
            $value = $this->diceArray[$diceNr]->rollOneDice();
            array_push($newDiceValues, $value);
        }
        return $newDiceValues;
    }

    public function getDiceValues(): array
    {
        $diceValues = [];
        for ($i=0; $i < 5 ; $i++) {
            $value = $this->diceArray[$i]->getDiceValue();
            array_push($diceValues, $value);
        }
        return $diceValues;
    }
}

class Round
{
    private object $hand;
    private int $reRollsCounter;

    public function __construct()
    {
        $this->hand = new Hand();
        $this->reRollsCounter = 0;
    }

    public function getRollsAndValues(): array
    {
        $values = $this->hand->getDiceValues();
        array_unshift($values, $this->reRollsCounter);
        return $values;
    }

    public function rollDice($keys): array
    {
        $this->hand->rollSelectedDice($keys);
        $this->reRollsCounter += 1;

        return $this->getRollsAndValues();
    }
}


class Yatzy
{
    private int $roundsCounter;
    private string $roundsLeft;
    private int $currentRound;
    private int $totalPoints;
    private object $currentHand;

    public function __construct()
    {
        $this->roundsCounter = 0;
        $this->totalPoints = 0;
        $this->roundsLeft = "123456";
    }

    public function startNewRound(): array
    {
        $rollsAndValues = [];
        $data = [];

        $this->roundsCounter += 1;
        $this->currentHand = new Round();
        $rollsAndValues = $this->currentHand->getRollsAndValues();

        $data["nrOfRerolls"] = $rollsAndValues[0];
        $data["diceArray"] = array_slice($rollsAndValues, -5);
        $data["nrOfRoundsPlayed"] = $this->roundsCounter;
        $roundsLeft = str_split($this->roundsLeft);
        $data["roundsLeft"] = $roundsLeft;
        $data["totalPoints"] = $this->totalPoints;
        $data["hideOn2RerollsMade"] = "";
        $data["showOn2RerollsMade"] = "hidden";
        $data["hideOnGameOver"] = "";
        $data["showOnGameOver"] = "hidden";

        return $data;
    }

    public function play($post): array
    {
        $data = [];

        if (isset($post["roundOver"])) {
            $this->roundsLeft = str_replace($post["selectedRound"],"", $this->roundsLeft);
            $this->currentRound = intval($post["selectedRound"]);

            $rollsAndValues = $this->currentHand->getRollsAndValues();
            $data["diceArray"] = array_slice($rollsAndValues, -5);

            $this->calculatePoints($data["diceArray"]);
            $data["totalPoints"] = $this->totalPoints;

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

    private function reRoll($diceToReroll): array
    {
        $rollsAndValues = [];
        $data = [];

        $rollsAndValues = $this->currentHand->rollDice($diceToReroll);

        $data["nrOfRerolls"] = $rollsAndValues[0];
        $data["diceArray"] = array_slice($rollsAndValues, -5);
        $data["nrOfRoundsPlayed"] = $this->roundsCounter;
        $roundsLeft = str_split($this->roundsLeft);
        $data["roundsLeft"] = $roundsLeft;
        $data["totalPoints"] = $this->totalPoints;
        $data["hideOn2RerollsMade"] = "";
        $data["showOn2RerollsMade"] = "hidden";
        $data["hideOnGameOver"] = "";
        $data["showOnGameOver"] = "hidden";

        if ($data["nrOfRerolls"] >= 2) {
            $data["hideOn2RerollsMade"] = "hidden";
            $data["showOn2RerollsMade"] = "";
            if ($this->roundsCounter == 6) {
                $this->currentRound = intval($this->roundsLeft);

                $this->calculatePoints($data["diceArray"]);
                $data["totalPoints"] = $this->totalPoints;

                $this->roundsLeft = "";
                $data["roundsLeft"] = [""];
                $data["hideOnGameOver"] = "hidden";
                $data["showOnGameOver"] = "";
            }
        }
        return $data;
    }

    private function calculatePoints($diceArray): int
    {
        foreach ($diceArray as $value) {
            if ($value == $this->currentRound) {
                $this->totalPoints += $value;
            }
        }
        if (($this->roundsCounter == 6) && ($this->totalPoints >= 63)) {
            $this->totalPoints += 50;
        }
        return $this->totalPoints;
    }
}

// 
// $yatzyObject = new Yatzy();
//
// $yatzyObject->startNewRound();
// $ett = $yatzyObject->currentHand;
//
// $yatzyObject->startNewRound();
// $two = $yatzyObject->currentHand;
//
// echo($ett == $two);
