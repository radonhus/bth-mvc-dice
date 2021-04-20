<?php

declare(strict_types=1);

namespace riax20\Game21;

class GraphicalDice extends Dice
{

    public function diceImage(): string
    {
        return "dice-" . $this->getLastRoll();
    }
}
