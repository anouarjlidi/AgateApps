
/**
 * Advantage immutable object type.
 *
 * @param object
 * @constructor
 * @property {Number} id
 * @property {Number} xp
 * @property {Number} baseValue
 * @property {Number} currentValue
 * @property {Number} augmentation
 * @property {boolean} isAdvantage
 * @property {Element} input
 * @property {Element} label
 */
var Advantage = function(object) {
    this.id           = !isNaN(parseInt(object.id)) ? parseInt(object.id, 10) : null;
    this.xp           = !isNaN(parseInt(object.xp)) ? parseInt(object.xp, 10) : null;
    this.baseValue    = !isNaN(parseInt(object.baseValue)) ? parseInt(object.baseValue, 10) : null;
    this.currentValue = !isNaN(parseInt(object.currentValue)) ? parseInt(object.currentValue, 10) : null;
    this.augmentation = !isNaN(parseInt(object.augmentation)) ? parseInt(object.augmentation, 10) : null;
    this.isAdvantage  = !!object.isAdvantage;
    this.input        = object.input || null;
    this.label        = object.label || null;
    Object.freeze(this);
};
