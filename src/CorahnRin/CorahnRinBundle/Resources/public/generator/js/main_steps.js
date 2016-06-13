"use strict";

(function($, d){
    var i, l;

    /**
     * Once an element has "data-onchangesubmit" attribute, its "change" event triggers submit in parent form.
     */
    if (d.querySelector('[data-onchangesubmit]')) {
        var changesubmitNodesList = d.querySelectorAll('[data-onchangesubmit]');
        for (i = 0, l = changesubmitNodesList.length; i < l; i++) {
            changesubmitNodesList[i].addEventListener('change', function(){
                var a = this.getAttribute('data-onchangesubmit'),
                    form;
                if (a !== 'false' && a !== '0') {
                    form = this.form;
                    if (form) {
                        form.submit();
                    } else {
                        console.warn('Tried to set onchangesubmit on an element that do not have a form as a parent.', this);
                    }
                }
                return false;
            });
        }
    }

    /**
     * Each "toggle increment" element is able to increment a value in an input or in an HTML tag.
     * "ti" stands for "toggle increment".
     *
     * @param data-ti-target-node    Node that will receive the output value.
     * @param data-ti-increment      Allows specifying the increment value (default: +1). Careful: we use "parseInt" for it.
     * @param data-ti-increment-max  Max value for this node.
     * @param data-ti-increment-min  Min value for this node.
     * @param data-ti-use-html       Use .innerHTML rather than .value when outputting the incremented value.
     * @param data-ti-sum-max        Get the sum of all elements in "data-ti-sum-selector", and checks that it does not reach the "sum-max".
     * @param data-ti-sum-selector   Used conjointedly with "data-ti-sum-max".
     */
    if (d.querySelector('data-toggle-increment')) {
        var incrementNodesList = d.querySelectorAll('data-toggle-increment');
        for (i = 0, l = incrementNodesList.length; i < l; i++) {
            incrementNodesList[i].addEventListener('click', function(e){
                var target      = this.getAttribute('data-ti-target-node'),
                    max         = this.getAttribute('data-ti-increment-max'),
                    min         = this.getAttribute('data-ti-increment-min'),
                    sumMax      = parseInt(this.getAttribute('data-ti-sum-max')),
                    sumSelector = this.getAttribute('data-ti-sum-selector'),
                    sum         = 0,
                    useHtml     = this.hasAttribute('data-ti-use-html'),
                    increment   = parseInt(this.getAttribute('data-ti-increment')),
                    value       = parseInt(useHtml ? d.getElementById(target).innerHTML : d.getElementById(target).value),
                    i, l, c, j // Only loop vars
                ;

                // Fix parameters NaN values
                if (isNaN(sumMax))    { sumMax = null; }
                if (isNaN(max))       { max = null; }
                if (isNaN(min))       { min = null; }
                if (isNaN(value))     { value = null !== min ? min : 0; }
                if (isNaN(increment)) { increment = 1; }

                if (null === sumMax) {
                    // Increment normally
                    value += increment;
                } else {
                    // If we have sumMax specified, there's another behavior
                    if (!sumSelector) {
                        console.error('When using data-ti-sum-max, a data-ti-sum-selector must be provided.');
                        return false;
                    }

                    // We loop through all nodes in the sumSelector and increment the sum value,
                    //   based on what we have in the node itself.
                    // We check according to the "useHtml" parameter.
                    // Any erroneous value is converted to zero.
                    for (i = 0, l = d.querySelectorAll(sumSelector), c = l.length; i < c; i++) {
                        if (useHtml) {
                            j = parseInt(l[i].innerHTML);
                        } else {
                            j = parseInt(l[i].value);
                        }
                        if (isNaN(j)) {
                            console.warn('When calculating the sum, a node has a wrong value (but we converted it to zero in case of).', l[i]);
                            j = 0;
                        }
                        sum += j;
                    }

                    // Increment only when sure it does not reach the sumMax requirement.
                    if (sum + increment <= sumMax) {
                        value += increment;
                    }
                }

                // Force value to be max or min if it is out of range.
                if (null !== max && value > max) { value = max; }
                if (null !== min && value < min) { value = min; }

                if (useHtml) {
                    d.getElementById(target).innerHTML = value.toString();
                } else {
                    d.getElementById(target).value = value;
                }

                e.preventDefault();
                return false;
            });
        }
    }

    /**
     * Fonction permettant d'utiliser des div pour changer la valeur d'un input
     */
    if (d.querySelector('.gen-div-choice')) {
        var divChoiceNodesList = d.querySelectorAll('.gen-div-choice');
        for (i = 0, l = divChoiceNodesList.length; i < l; i++) {
            divChoiceNodesList[i].addEventListener('click', function () {
                var nodes = d.getElementsByClassName('gen-div-choice'),
                    count = nodes.length,
                    node;
                if (this.classList.contains('selected')) {
                    return false;
                }
                if (this.classList.contains('divchoice-button')) {
                    return false;
                }
                for (var i = 0; i < count; i++) {
                    nodes[i].classList.remove('selected');
                    if (nodes[i].getAttribute('data-divchoice-inside') === 'true') {
                        $(nodes[i].querySelector('.divchoice-inside')).slideUp(400);
                        for (var l = nodes[i].querySelectorAll('.divchoice-inside .btn'), c = l.length, j = 0; j < c; j++) {
                            l[j].classList.remove('active');
                            l[j].firstElementChild.checked = false;
                        }
                    }
                }
                this.classList.add('selected');
                if (this.getAttribute('data-target-node')) {
                    node = d.querySelector(this.getAttribute('data-target-node'));
                } else {
                    node = d.getElementById('gen-div-choice');
                }
                if (this.getAttribute('data-divchoice-inside') === 'true') {
                    $(this.querySelector('.divchoice-inside')).slideDown(400);
                }
                node.value = this.getAttribute('data-div-choice-value');
                return false;
            });
        }
    }

    $('[data-toggle="buttons"][data-max-buttons] .btn').bind('click.maxbuttons', function(){
        var parent = $(this).data('jq_parent');
        if (!parent) {
            parent = $(this).parents('[data-max-buttons]')[0];
            $(this).data('jq_parent', parent);
        }

        var max = $(this).data('jq_max_number');
        if (!max) {
            max = parent.getAttribute('data-max-buttons');
            $(this).data('jq_max_number', max);
        }

        if (this.classList.contains('active')) {
            this.classList.remove('active');
            this.firstElementChild.checked = false;
        } else {
            this.classList.add('active');
            this.firstElementChild.checked = true;
        }

        var elements = parent.querySelectorAll('label.active');
        console.info(elements);
        if (elements.length > max) {
            for (var i = max,c = elements.length; i < c ; i++) {
                elements[i].classList.remove('active');
                elements[i].firstElementChild.checked = false;
            }
        }
    });

    /**
     * Fonction permettant d'activer les boutons et un input associé
     */
    $('[data-toggle="btn-gen-choice"]').bind('mousedown', function(){var e=this;setTimeout(function(){
        var node,
            count,
            i,
            prev = e.previousElementSibling,
            selector = '[data-toggle="btn-gen-choice"].active'
        ;
        if (e.getAttribute('data-group')) {
            selector += '[data-group="'+e.getAttribute('data-group')+'"]';
        }
        node = d.querySelectorAll(selector);
        count = node.length;
        for (i=0;i<count;i++){
            node[i].classList.remove('active');
            if (node[i].previousElementSibling) {
                if (node[i].previousElementSibling.classList.contains('btn')) {
                    node[i].previousElementSibling.classList.remove('active');
                }
            }
        }
        e.classList.add('active');
        if (prev) {
            if (prev.classList.contains('btn')) {
                prev.classList.add('active');
            }
        }
        d.getElementById(e.getAttribute('data-target-node')).value = e.getAttribute('data-input-value');
    },1);});

    /**
     * Clic distant sur un élément
     */
    $('[data-toggle="btn-dist-click"]').bind('mouseup', function(){
        $(d.getElementById(this.getAttribute('data-target-node'))).mousedown();
    });

    (function(){
        var el, i,
            l = d.querySelectorAll('[data-toggle="ui-slider"]'),
            c = l.length;
        /**
         * Sliders UI
         */
        for (i = 0; i < c; i++) {
            el = l[i];
            $(el).slider({
                'range': el.getAttribute('data-slider-range') ? el.getAttribute('data-slider-range') : 'min',
                'value': el.getAttribute('data-slider-value') ? parseInt(el.getAttribute('data-slider-value')) : 0,
                'min': el.getAttribute('data-slider-min') ? parseInt(el.getAttribute('data-slider-min')) : 0,
                'max': el.getAttribute('data-slider-max') ? parseInt(el.getAttribute('data-slider-max')) : 0,
                'slide': function (e, ui) {
                    var id;
                    id = $(e.target).attr('data-slider-label');
                    if (id) {
                        d.getElementById(id).innerHTML = ui.value;
                    }
                    id = $(e.target).attr('data-slider-input');
                    if (id) {
                        d.getElementById(id).value = ui.value;
                    }
                }
            });
        }
    })();

})(jQuery, document, window);
