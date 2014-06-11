(function($){

    /**
     * Fonction permettant d'utiliser des div pour changer la valeur d'un input
     */
    $('.gen-div-choice').on('click', function(){
        var nodes = document.getElementsByClassName('gen-div-choice'),
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
            node = document.querySelector(this.getAttribute('data-target-node'));
        } else {
            node = document.getElementById('gen-div-choice');
        }
        if (this.getAttribute('data-divchoice-inside') === 'true') {
            $(this.querySelector('.divchoice-inside')).slideDown(400);
        }
        node.value = this.getAttribute('data-div-choice-value');
        return false;
    });

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
        node = document.querySelectorAll(selector);
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
        document.getElementById(e.getAttribute('data-target-node')).value = e.getAttribute('data-input-value');
    },1);});

    /**
     * Clic distant sur un élément
     */
    $('[data-toggle="btn-dist-click"]').bind('mouseup', function(){
        $(document.getElementById(this.getAttribute('data-target-node'))).mousedown();
    });

    (function(){
        var el, i,
            l = document.querySelectorAll('[data-toggle="ui-slider"]'),
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
                    id = ui.handle.attr('data-slider-label');
                    if (id) {
                        document.getElementById(id).innerHTML = ui.value;
                    }
                    id = ui.handle.attr('data-slider-input');
                    if (id) {
                        document.getElementById(id).value = ui.value;
                    }
                }
            });
        }
    })();

})(jQuery);