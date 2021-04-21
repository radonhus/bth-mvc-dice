<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);
use function Mos\Functions\url;

$message = $message ?? null;
$standings = $standings ?? null;

?><h1>Game 21</h1>

<p>Your latest roll:</p>

<p class="dice-utf8">
<?php foreach ($diceImages as $key => $value) : ?>
    <i class="<?= $value ?>"></i>
<?php endforeach; ?>
</p>

<p <?= $hideOnGameOver ?>>Your accumulated points: <?= $userSum ?></p>

<p><?= $message ?></p>

<form method="post" class="game21-form" action="<?= url('/game21') ?>" <?= $hideOnGameOver ?>>
    <label for="rollagain">Roll again?</label>
    <input type="submit" name="rollagain" value="Roll again" class="submit">
    <input type="submit" name="stop" value="Stop" class="submit">
</form>

<h2 <?= $showOnGameOver ?>>New round?</h2>
<p <?= $showOnGameOver ?>><?= $standings ?></p>
<form method="post" class="game21-form" action="<?= url('/game21/initiate') ?>" <?= $showOnGameOver ?>>
    <label for="oneortwo">Number of dice: </label>
    <select name="oneortwo">
        <option value="1" selected="selected">1</option>
        <option value="2">2</option>
    </select>
    <br>
    <input type="submit" name="startgame" value="New round" class="submit">
    <input type="submit" name="clearstandings" value="Clear standings + new round" class="submit">
</form>
