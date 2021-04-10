Yatzy Class constructor method, gets called from controller class and initiates a new YatzyObject
    SET roundsCounter to 0
    SET totalPoints to 0
    SET currentRound to NULL;
    CALL Yatzy method startNewRound on YatzyObject

Method startNewRound gets called from constructor method or from controller class.
    Increase roundsCounter with 1
    INIT a new Round class object, save in currentRound property
    CALL Round method getRollsAndValues on currentRound
        RETURN values array with diceValues + nrOfRerolls
    SET data.diceArray to diceValues
    SET data.nrOfRerolls to nrOfRerolls
    SET data.roundsCounter to roundsCounter
    SET data.totalPoints to totalPoints
    RETURN data

Method reRoll takes diceToReroll as parameter. Gets called from controller class.
    CALL Round method rollDice on currentRound with diceToReroll
    RETURN "values" array with diceValues + nrOfRerolls
    IF nrOfRerolls equals 2 THEN
        CALL Yatzy method calculatePoints with diceValues
    SET data.diceArray to diceValues
    SET data.nrOfRerolls to nrOfRerolls
    SET data.roundsCounter to roundsCounter
    SET data.totalPoints to totalPoints
    RETURN data

Method calculatePoints takes diceValues as parameter. Gets called from reRoll method.
    FOR every diceValue in diceValues
        IF diceValue equals roundsCounter THEN
            Increase totalPoints with diceValue
        IF roundsCounter equals 6 and totalPoints is 63 or more THEN
            Increase totalPoints with 50 bonus points
