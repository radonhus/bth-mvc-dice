<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$message = $message ?? null;

?><h1>Dice</h1>

<p><?= $message ?></p>

<form method="POST" class="game21-form">
    <label for="oneortwo">Number of dice in each roll: </label>
    <select name="oneortwo">
        <option value="1" selected="selected">1</option>
        <option value="2">2</option>
    </select>
    <input type="submit" name="startgame" value="Start!" class="submit">
</form>
