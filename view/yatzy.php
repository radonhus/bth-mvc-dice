<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);
use function Mos\Functions\url;

$message = $message ?? null;
$_POST = $_POST ?? null;
var_dump($_POST);
echo "<br><br>";
?><h1>Yatzy</h1>

<p>This round, collect dice with the value: <?= $round ?></p>

<form method="post" class="yatzy-form" action="<?= url('/yatzy') ?>">
    <div class="yatzy-dice">
        <?php foreach($diceArray as $key=>$value): ?>
        <div class="onedice">
            <img src="<?= url('/img/' . $value . '.png') ?>" class="dice-image"><br>
            <input type="checkbox" name="<?= $key ?>" value="selected" <?= $hideOnRoundOver ?>>
        </div>
        <?php endforeach; ?>
    </div>
    <input type="submit" name="roll" value="Roll selected dice" class="submit" <?= $hideOnRoundOver ?>>
</form>

<p>Rerolls made: <?= $nrOfRerolls ?></p>

<p <?= $showOnRoundOver ?>>Round is over. Total points thus far: <?= $totalPoints ?></p>

<form method="post" class="yatzy-form" action="<?= url('/yatzy') ?>">
    <input type="submit" name="nextround" value="Next round" class="submit" <?= $showOnRoundOver ?> <?= $hideOnGameOver ?>>
</form>
