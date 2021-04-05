<?php

declare(strict_types=1);

namespace riax20\Dice;

class GraphicalDice extends Dice
{
    const SIDES = 6;

    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function diceImage(): string
    {
        return "dice-" . $this->getLastRoll();
    }
}
