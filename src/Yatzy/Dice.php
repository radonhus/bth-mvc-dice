<?php

declare(strict_types=1);

namespace riax20\Yatzy;

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
