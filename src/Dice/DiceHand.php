<?php

declare(strict_types=1);

namespace riax20\Dice;

class DiceHand
{
    private array $allDice;

    public function __construct($nrOfDice)
    {
        $this->allDice = [];
        for ($i = 0; $i < $nrOfDice ; $i++) {
            $newDice = new GraphicalDice();
            array_push($this->allDice, $newDice);
        }
    }

    public function rollAllDice(): void
    {
        for ($i=0; $i < count($this->allDice) ; $i++) {
            $this->allDice[$i]->rollDice();
        }
    }

    public function getLastRolls(): array
    {
        $rollsArray = [];
        for ($i=0; $i < count($this->allDice) ; $i++) {
            array_push($rollsArray, $this->allDice[$i]->getLastRoll());
        }
        return $rollsArray;
    }

    public function getLastRollsImages(): array
    {
        $imagesArray = [];
        for ($i=0; $i < count($this->allDice) ; $i++) {
            array_push($imagesArray, $this->allDice[$i]->diceImage());
        }
        return $imagesArray;
    }

}
