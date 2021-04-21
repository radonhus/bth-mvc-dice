<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);
use function Mos\Functions\url;

$message = $message ?? null;
$_POST = $_POST ?? null;
?><h1>Yatzy</h1>

<div class="yatzy-status" <?= $hideOnGameOver ?>>
    <p>Round nr. <?= $nrOfRoundsPlayed ?>/6</p>
    <p>Your score so far: <?= $totalPoints ?></p>
    <p>Rounds left:</p>
    <?php foreach ($roundsLeft as $value) : ?>
    <img src="<?= url('/img/' . $value . '.png') ?>" class="dice-image-small">
    <?php endforeach; ?>
</div>

<div class="yatzy-status" <?= $showOnGameOver ?>>
    <p>Your final score: <?= $totalPoints ?></p>
</div>

<form method="post" class="yatzy-form" action="<?= url('/yatzy') ?>">
    <p <?= $hideOn2RerollsMade ?>>Select which dice to roll again (rerolls made: <?= $nrOfRerolls ?>)</p>
    <div class="yatzy-dice">
        <?php foreach ($diceArray as $key => $value) : ?>
        <div class="onedice">
            <img src="<?= url('/img/' . $value . '.png') ?>" class="dice-image"><br>
            <input type="checkbox" name="<?= $key ?>" value="selected" <?= $hideOn2RerollsMade ?>>
        </div>
        <?php endforeach; ?>
    </div>
    <input type="submit" name="roll" value="Roll selected dice" class="submit" <?= $hideOn2RerollsMade ?>>
</form>

<form method="post" class="yatzy-form" action="<?= url('/yatzy') ?>">
    <label for="selectedRound" <?= $showOn2RerollsMade ?> <?= $hideOnGameOver ?>>Round is over. Save points as: </label>
    <select name="selectedRound" <?= $showOn2RerollsMade ?> <?= $hideOnGameOver ?>>
        <?php foreach ($roundsLeft as $value) : ?>
            <option value="<?= $value ?>"><?= $value ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="roundOver" value="Save points + start next round" class="submit" <?= $showOn2RerollsMade ?> <?= $hideOnGameOver ?>>
</form>
