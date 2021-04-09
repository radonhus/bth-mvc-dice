<?php

declare(strict_types=1);

namespace riax20\Yatzy;
use riax20\Yatzy\Hand;

class Round
{
    private object $hand;
    private int $rollsCounter;

    public function __construct()
    {
        $this->hand = new Hand();
        $this->rollsCounter = 1;
    }

    public function getValues(): array
    {
        return $this->hand->getDiceValues();
    }

    public function rollDice($keys): array
    {
        if ($this->rollsCounter < 3) {
            $this->hand->rollSelectedDice($keys);
            $this->rollsCounter += 1;
        }

        return $this->hand->getDiceValues();
    }
}
