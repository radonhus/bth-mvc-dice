<?php

declare(strict_types=1);

namespace riax20\Game21;

class Dice
{
    private int $lastRoll;
    private int $sides;

    public function __construct($sides)
    {
        $this->sides = $sides;
        $this->lastRoll = $this->rollDice();
    }

    public function rollDice(): int
    {
        $this->lastRoll = rand(1, $this->sides);
        return $this->lastRoll;
    }

    public function getLastRoll(): int
    {
        return $this->lastRoll;
    }

    public function changeDiceSize($newSize)
    {
        $this->sides = $newSize;
    }

}
