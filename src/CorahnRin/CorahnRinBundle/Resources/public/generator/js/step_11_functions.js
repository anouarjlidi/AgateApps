
/**
 * Get a plain object representing the advantage, based on an HTML input.
 *
 * @param {Element} input
 * @param {Element} label
 *
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
 * Calculate exp from advantage.
 * If "virtualValue" is specified, will calculate as if the advantage had specific value.
 *
 * @param {Advantage} advantage
 * @param {Number}    [virtualValue]
 *
 * @returns {number}
 */
function calculateXpFromAdvantage(advantage, virtualValue) {
    var value, xp;

    if (null !== virtualValue && typeof virtualValue !== 'undefined') {
        value = virtualValue;
    } else {
        value = advantage.input.value;
    }

    value = parseInt(value, 10);

    if (isNaN(value)) {
        throw 'Incorrect value for input.';
    }

    if (advantage.id === 50) {
        // Case of the "Trauma" disadvantage.
        return value * advantage.xp;
    }

    if (value === 0) {
        return 0;
    } else if (value === 1) {
        xp = advantage.xp;
    } else if (value === 2 && advantage.augmentation > 0) {
        xp = Math.floor(advantage.xp * 1.5);
    } else if (value > 2) {
        throw 'Incorrect value for advantage / disadvantage';
    }

    // Negative exp for advantages.
    if (advantage.isAdvantage) {
        xp *= (-1);
    }

    return xp;
}

/**
 * @param {Advantage} advantage
 * @param {Number}    [forceValue]
 */
function updateAdvantageValue(advantage, forceValue) {
    var value = parseInt(advantage.input.value, 10);
    var classList;

    forceValue = typeof forceValue !== 'undefined' ? parseInt(forceValue, 10) : null;

    if (isNaN(value)) {
        throw 'Incorrect value for input. Check your code.';
    }
    if (isNaN(forceValue) || forceValue < 0 || forceValue > 3) {
        throw 'Incorrect force value, must be a number or undefined.';
    }

    if (null !== forceValue) {
        value = forceValue;
    } else {
        value++;
    }

    // Reset value to 0 if it exceeds a specific value.
    // For Trauma, max is 3,
    //  else max is 2.
    if (
        (advantage.id === 50 && value > 3)
        || (advantage.id !== 50 && value > 2)
        || (advantage.augmentation === 0 && value >= 2)
    ) {
        value = 0;
    }

    // Edge case possible with bad code.
    if (value < 0) {
        throw 'Incorrect negative value.';
    }

    // Update input value.
    advantage.input.value = value;

    // Update label classes.
    classList = advantage.label.className.replace(/btn-state-[0-9]+/gi, '').trim();

    if (value) {
        classList += ' btn-state-'+value;
    }

    advantage.label.className = classList;
}

/**
 * @param {Number}    currentAdvantageId
 * @param {Number}    experience
 * @param {{}}        advantagesList
 * @param {Number}    [deep]
 *
 * @returns {Number}
 */
function gainOrSpendExperience(currentAdvantageId, experience, advantagesList, deep) {
    var experienceGainedWithDisadvantages = 0;
    var numberOfAdvantages = 0;

    if (typeof deep === 'undefined') {
        deep = 0;
    }

    if (deep > 10) {
        throw 'More than 10 loops when calculating disadvantages, something is going on.';
    }

    for (var elementId in advantagesList) {
        if (!advantagesList.hasOwnProperty(elementId)) { continue; }

        // Do not process current advantage
        if (elementId.toString() === currentAdvantageId.toString()) { console.info('same advantage, do not process.'); continue; }

        var advantageOrDisadvantage = advantagesList[elementId];

        // Get xp from function.
        var xpGained = calculateXpFromAdvantage(advantageOrDisadvantage);

        if (0 === xpGained) {
            continue;
        }

        numberOfAdvantages++;

        if (
            (advantageOrDisadvantage.isAdvantage && (numberOfAdvantages >= 4 || experience + xpGained < 0))
            ||
            (!advantageOrDisadvantage.isAdvantage && (numberOfAdvantages >= 4 || experienceGainedWithDisadvantages + xpGained > 80))
        ) {
            updateAdvantageValue(advantageOrDisadvantage, advantageOrDisadvantage.input.value - 1);

            return gainOrSpendExperience(currentAdvantageId, experience, advantagesList, deep + 1);
        }

        experience += xpGained;
    }

    return experience;
}
