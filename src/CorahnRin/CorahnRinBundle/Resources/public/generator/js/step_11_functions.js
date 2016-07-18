

/**
 * Get a plain object representing the advantage, based on an HTML input.
 *
 * @param input Element
 * @param label Element
 * @returns {Advantage}
 */
function getAdvantageFromInput(input, label){
    var id = parseInt(input.getAttribute('data-element-id'));
    var xp = parseInt(input.getAttribute('data-element-cost'));
    var currentValue = parseInt(input.value);
    var augmentation = parseInt(input.getAttribute('data-augmentation'));
    var isAdvantage = null;

    // If these elements are not numbers,
    // it means someone attempted to override DOM values.
    if (isNaN(xp) || isNaN(currentValue) || isNaN(augmentation) || isNaN(id)) {
        throw 'Wrong values';
    }

    // Determine whether it's an advantage or a disadvantage.
    if (label.classList.contains('change_desv')) {
        isAdvantage = false;
    } else if (label.classList.contains('change_avtg')) {
        isAdvantage = true;
    } else {
        throw 'Wrong element class, missing change_avtg or change_desv.';
    }

    return new Advantage({
        'id': id,
        'xp': xp,
        'baseValue': currentValue,
        'currentValue': currentValue,
        'augmentation': augmentation,
        'isAdvantage': isAdvantage,
        'input': input,
        'label': label
    });
}

/**
 *
 * @param advantage Advantage
 * @returns {number}
 */
function calculateXpFromAdvantage(advantage) {
    var value = parseInt(advantage.input.value);
    var xp;

    if (isNaN(value)) {
        throw 'Incorrect value for input.';
    }

    if (advantage.id == 50) {
        // Case of the "Trauma" disadvantage.
        return (-1) * value * advantage.xp;
    }

    if (value === 0) {
        return 0;
    } else if (value === 1) {
        xp = advantage.xp;
    } else if (value === 2) {
        xp = advantage.xp * 1.5;
    } else {
        throw 'Incorrect value for advantage / disadvantage';
    }

    // Negative exp for disadvantages.
    if (!advantage.isAdvantage) {
        xp *= (-1);
    }

    return xp;
}
