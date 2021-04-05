<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$message = $message ?? null;
$standings = $standings ?? null;

?><h1>Dice</h1>

<form method="post" class="game21-form" <?= $showOnGameOver ?>>
    <label for="newgame">New round?</label>
    <label for="oneortwo">Number of dice: </label>
    <select name="oneortwo">
        <option value="1" selected="selected">1</option>
        <option value="2">2</option>
    </select>
    <br>
    <input type="submit" name="startgame" value="New round" class="submit">
    <input type="submit" name="clearstandings" value="Clear standings + new round" class="submit">
</form>

<p>Your latest roll:</p>

<p class="dice-utf8">
<?php foreach($diceImages as $key=>$value): ?>
    <i class="<?= $value ?>"></i>
<?php endforeach; ?>
</p>

<p <?= $hideOnGameOver ?>>Your accumulated points: <?= $userSum ?></p>

<p><?= $message ?></p>

<p <?= $showOnGameOver ?>><?= $standings ?></p>

<form method="post" class="game21-form" <?= $hideOnGameOver ?>>
    <label for="rollagain">Roll again?</label>
    <input type="submit" name="rollagain" value="Roll again" class="submit">
    <input type="submit" name="stop" value="Stop" class="submit">
</form>
