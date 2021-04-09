<?php

declare(strict_types=1);

namespace riax20\Yatzy;
use riax20\Yatzy\Dice;

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

    public function rollSelectedDice($keys): void
    {
        $nrOfDice = count($keys);
        for ($i=0; $i < $nrOfDice ; $i++) {
            $diceNr = $keys[$i];
            $this->diceArray[$diceNr]->rollOneDice();
        }
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
