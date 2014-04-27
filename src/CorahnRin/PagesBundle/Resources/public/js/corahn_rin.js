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
};

(function($, d, w){
    var a;

    String.prototype.trim=function(){
        return this.replace(/^\s+|\s+$/g, '');
    };

    // Placement dynamique d'une tooltip
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

    // Messages de confirmation de suppression (propre au BO)
    a = d.querySelectorAll('a.btn-danger[href*=delete]');
    for (var i = 0, l = a.length ; i < l ; i++) {
        $(a[i]).on('click', function(){
            return confirm(CONFIRM_DELETE);
        });
    }

    // Applique un "submit" au formulaire parent lorsque l'évènement se voit appliquer l'évènement "onchange"
    a = d.querySelectorAll('[data-onchangesubmit]');
    for (var i = 0, l = a.length ; i < l ; i++) {
        $(a[i]).on('change', function(){
            var a = this.getAttribute('data-onchangesubmit');
            if (a !== 'false' && a !== '0') {
                if ($(this).parents('form')) {
                    $(this).parents('form').submit();
                }
            }
            return false;
        });
    }


    // Form prototype (sélection multiple, propre au BO)
    if (d.querySelectorAll('[data-prototype]').length) {

        var handler = d.getElementById('corahnrin_pagesbundle_menus_params'),
            elements = d.querySelectorAll('[data-collection-children]'),
            onclick = function(){
                $(this).parents('.input-group').remove();
            },
            prototype,
            inputContainer,
            spanNode,
            addElementNode,
            deleteElementNode;

        prototype = $(handler.getAttribute('data-prototype').trim()).find('input')[0];
        spanNode = d.createElement('span');
        spanNode.appendChild(prototype);
        prototype = spanNode.innerHTML;

        deleteElementNode = d.createElement('button');
        deleteElementNode.className = 'btn btn-delete';
        deleteElementNode.type = 'button';
        deleteElementNode.innerHTML = '<span class="glyphicon icon-bin text-red"></span>';

        spanNode = d.createElement('span');
        spanNode.className = 'input-group-btn span-delete-node';
        spanNode.appendChild(deleteElementNode);

        inputContainer = d.createElement('div');
        inputContainer.className = 'input-group';

        addElementNode = d.createElement('button');
        addElementNode.className = 'btn btn-inverse btn-xs btn-block';
        addElementNode.type = 'button';
        addElementNode.innerHTML = '<span class="glyphicon icon-plus text-green"></span>';
        addElementNode.onclick = function(){
            var iterator = !isNaN(d.iteratorValue) ? d.iteratorValue : 0,
                node = d.createElement('div'),
                handler = d.getElementById('corahnrin_pagesbundle_menus_params'),
                container = inputContainer.cloneNode(),
                spanNodeToAdd = spanNode.cloneNode();
            spanNodeToAdd.onclick = onclick;
            container.innerHTML += prototype;
            node.appendChild(container);
            node.innerHTML = node.innerHTML.replace(/__name__/gi, iterator);
            $(node).find('input').after(spanNodeToAdd);
            handler.appendChild(node);
            d.iteratorValue = iterator + 1;
        };
        handler.innerHTML = '';
        handler.appendChild(addElementNode);


        for (var i = 0, l = elements.length ; i < l ; i++) {
            elements[i];
        }

    }// end form prototypes


    /**
     * Implémentation de petits blocs de boutons et inputs pour incrémenter des valeurs dans un élément
     */
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
            for (var i = 0, l = d.querySelectorAll(sumSelector), c = l.length ; i < c ; i++) {
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

})(jQuery, document, window);