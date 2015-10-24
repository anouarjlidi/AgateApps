/**
 * Merges two objects recursively
 * @param targetObject object
 * @param sourceObject object
 * @returns {*}
 */
function mergeRecursive (targetObject, sourceObject) {
    var property;
    if (!targetObject) { targetObject = {}; }
    if (!sourceObject) { sourceObject = {}; }
    for (property in sourceObject) {
        if (sourceObject.hasOwnProperty(property)) {
            try {
                targetObject[property] =
                    (sourceObject[property].constructor == Object)
                        ? this.mergeRecursive(targetObject[property], sourceObject[property])
                        : sourceObject[property];
            }
            catch(e) { targetObject[property] = sourceObject[property]; }
        }
    }
    return targetObject;
}

(function($, d, w){
    var a, c, i, l;

    if (!String.prototype.trim) {
        // Méthode .trim() pour toutes les chaînes de caractères
        String.prototype.trim = function(){
            return this.replace(/^\s+|\s+$/g, '');
        };
    }

    // Placement dynamique d'une tooltip
    if (d.querySelector('[data-toggle="tooltip"]')) {
        $('[data-toggle="tooltip"]').tooltip({
            "placement" : function(event,element){
                return element.getAttribute('data-placement') ? element.getAttribute('data-placement') : 'auto bottom';
            },
            "container": "body"
        }).on('show.bs.tooltip', function(){
            var btn = this;
            $('[data-toggle="tooltip"]').filter(
                function(i,element){
                    return element != btn;
                }
            ).tooltip('hide');
        });
    }

    // Messages de confirmation de suppression (propre au BO)
    a = d.querySelectorAll('a.btn-danger[href*=delete]');
    for (i = 0, l = a.length ; i < l ; i++) {
        $(a[i]).on('click', function(){
            return confirm(CONFIRM_DELETE);
        });
    }

    // Applique un "submit" au formulaire parent lorsque l'évènement se voit appliquer l'évènement "onchange"
    if (d.querySelector('[data-onchangesubmit]')) {
        $('[data-onchangesubmit]').on('change', function(){
            var a = this.getAttribute('data-onchangesubmit'),
                form;
            if (a !== 'false' && a !== '0') {
                form = $(this).parents('form');
                if (form) {
                    form.submit();
                } else {
                    console.warn('Tried to set onchangesubmit on an element that do not have a form as a parent.', this);
                }
            }
            return false;
        });
    }

    /**
     * Implémentation de petits blocs de boutons et inputs pour incrémenter des valeurs dans un élément
     */
    if (d.querySelector('[data-toggle="increment"]')) {
        $('[data-toggle="increment"]').on('click', function(){
            var target = this.getAttribute('data-target-node'),
                max = this.getAttribute('data-increment-max'),
                min = this.getAttribute('data-increment-min'),
                sumMax = parseInt(this.getAttribute('data-sum-max')),
                sumSelector = this.getAttribute('data-sum-selector'),
                sum = 0,
                j,
                useHtml = this.getAttribute('data-use-html') == 'true',
                increment = parseInt(this.getAttribute('data-increment')),
                value = parseInt(useHtml ? d.getElementById(target).innerHTML : d.getElementById(target).value);

            if (isNaN(sumMax)) { sumMax = null; }
            if (isNaN(max)) { max = null; }
            if (isNaN(min)) { min = null; }
            if (isNaN(value)) { value = null !== min ? min : 0; }
            if (isNaN(increment)) {
                console.error('Error in incrementation value for target '+target);
                return false;
            }

            if (null !== sumMax) {
                for (i = 0, l = d.querySelectorAll(sumSelector), c = l.length ; i < c ; i++) {
                    if (useHtml) {
                        j = parseInt(l[i].innerHTML);
                    } else {
                        j = parseInt(l[i].value);
                    }
                    if (isNaN(j)) { j = 0; }
                    sum += j;
                }
                if (sum + increment <= sumMax) {
                    value += increment;
                }
            } else {
                value += increment;
            }


            if (null !== max && value > max) { value = max; }
            if (null !== min && value < min) { value = min; }

            if (useHtml) {
                d.getElementById(target).innerHTML = value;
            } else {
                d.getElementById(target).value = value;
            }
            return false;
        });
    }

})(jQuery, document, window);