(function($){

    /**
     * Fonction permettant d'utiliser des div pour changer la valeur d'un input
     */
    $('.gen-div-choice').click(function(){
        var node = document.getElementsByClassName('gen-div-choice'), count = node.length;
        if (this.classList.contains('selected')) {
            return false;
        }
        for (var i = 0; i < count; i++) {
            node[i].classList.remove('selected');
        }
        this.classList.add('selected');
        if (this.getAttribute('data-target-node')) {
            node = document.querySelector(this.getAttribute('data-target-node'));
        } else {
            node = document.getElementById('gen-div-choice');
        }
        node.value = this.getAttribute('data-div-choice-value');
    });
    
    $('[data-toggle="button-gen-choice"]').click(function(){
        var node, count, baseClass;
        if (this.classList.contains('btn-inverse')) {
            return false;
        }
        node = document.querySelectorAll('[data-toggle="button-gen-choice"].btn-inverse');
        count = node.length;
        for (var i = 0; i < count; i++) {
            baseClass = node[i].getAttribute('data-base-class');
            node[i].classList.remove('btn-inverse');
            node[i].classList.add( baseClass ? baseClass : 'btn-default');
            if (node[i].previousElementSibling.classList.contains('btn') && node[i].previousElementSibling.parentNode.classList.contains('btn-group')) {
                node[i].previousElementSibling.classList.remove('btn-inverse');
                node[i].previousElementSibling.classList.add( baseClass ? baseClass : 'btn-default');
            }
        }
        node = document.querySelectorAll('[data-toggle="button-gen-choice"][data-input-value="'+this.getAttribute('data-input-value')+'"]');
        count = node.length;
        for (var i = 0; i < count; i++) {
            baseClass = node[i].getAttribute('data-base-class');
            node[i].classList.add('btn-inverse');
            if (node[i].previousElementSibling.classList.contains('btn') && node[i].previousElementSibling.parentNode.classList.contains('btn-group')) {
                node[i].previousElementSibling.classList.add('btn-inverse');
            }
        }
        if (this.previousElementSibling.classList.contains('btn') && this.previousElementSibling.parentNode.classList.contains('btn-group')) {
            this.previousElementSibling.classList.add('btn-inverse');
        }
        node = document.querySelector(this.getAttribute('data-target-node'))
        node.value = this.getAttribute('data-input-value');
    });
    
    
})(jQuery);